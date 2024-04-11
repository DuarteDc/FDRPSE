<?php

namespace App\application\survey;

use App\domain\category\Category;
use App\domain\domain\Domain;
use App\domain\guideSurvey\GuideStatus;
use App\domain\guideSurvey\GuideSurveyRepository;
use App\domain\guideUser\GuideUser;
use App\domain\guideUser\GuideUserRepository;
use App\domain\qualification\Qualification;
use App\domain\qualificationQuestion\QualificationQuestion;
use App\domain\qualificationQuestion\QualificationQuestionRepository;
use Exception;
use App\kernel\authentication\Auth;

use App\domain\survey\Survey;
use App\domain\survey\SurveyRepository;
use App\domain\question\QuestionRepository;
use App\domain\section\Section;
use Illuminate\Database\Eloquent\Collection;

class SurveyService
{
    use Auth;

    public function __construct(
        private readonly SurveyRepository $surveyRepository,
        private readonly GuideUserRepository $guideUserRepository,
        private readonly QuestionRepository $questionRepository,
        private readonly GuideSurveyRepository $guideSurveyRepository,
        private readonly QualificationQuestionRepository $qualificationQuestionRepository,
    ) {
    }

    public function getSurvys(int $page)
    {
        return $this->surveyRepository->findAllSurveys($page);
    }

    public function getSurveyDetail(string $surveyId)
    {
        return $this->surveyRepository->findSurveyWithDetails($surveyId);
    }

    public function startSurvey()
    {
        if (!$this->surveyRepository->canStartNewSurvey()) return new Exception('Hay un cuestionatio en progreso por lo que no se puede comenzar la nueva encuesta', 400);
        return $this->surveyRepository->create(['start_date' => date('Y-m-d\TH:i:s.000'), 'status' => Survey::PENDING]);
    }

    public function saveNongradableAnswersByUser(array $body)
    {
        $guideSurvey = $this->guideSurveyRepository->findGuideInProgress();

        if (!$guideSurvey) return new Exception('Parece que hubo un error al registar la respusta', 400);

        $guideUser = $this->guideUserRepository->getCurrentGuideUser($guideSurvey->guide_id, $this->auth()->id, $guideSurvey->survey_id);

        if (!$guideUser) return new Exception('Parece que hubo un error al registar la respusta', 500);

        if (count($body) === 1) {
            $section = $this->guideSurveyRepository->findQuestionInsideGuide($guideSurvey, $body[0]['question_id']);
            $body =  $this->validateCanFinishedQuestion($section, $body[0]['qualification']);

            $guideUser = $this->guideUserRepository->getCurrentGuideUser($guideSurvey->guide_id, $this->auth()->id,  $guideSurvey->survey_id);

            if ($guideUser->answers != "") $body = $this->hasPreviousQuestion($guideUser->answers, [$body]);
            else $body = [$body];

            $this->guideUserRepository->saveAnswer($guideUser, $body);
            return ['message' => 'La preguntas se guardaron correctmente', 'guide' => $guideUser];
        }

        $isValidRequest = $this->validateQuestions($body);

        if (in_array(false, $isValidRequest)) return new Exception('Parece que hubo un error al guardar las preguntas', 400);

        $guideUser = $this->guideUserRepository->getCurrentGuideUser($guideSurvey->guide_id, $this->auth()->id,  $guideSurvey->survey_id);

        if ($guideUser->answers != "") $body = $this->hasPreviousQuestion($guideUser->answers, $isValidRequest);

        else $body = $isValidRequest;

        $this->guideUserRepository->saveAnswer($guideUser, $body);
        return ['message' => 'La preguntas se guardaron correctmente', 'guide' => $guideUser];
    }

    public function saveAnswersByUser(array $body)
    {
        $guideSurvey = $this->guideSurveyRepository->findGuideInProgress();
        if (!$guideSurvey) return new Exception('Parece que hubo un error al registar la respusta', 400);

        $guideUser = $this->guideUserRepository->getCurrentGuideUser($guideSurvey->guide_id, $this->auth()->id, $guideSurvey->survey_id);
        if (!$guideUser) return new Exception('Parece que hubo un error al registar la respusta', 500);

        $isValidRequest = $this->validateQuestions($body);

        if (in_array(false, $isValidRequest)) return new Exception('Las preguntas que intentas guardar no exiten', 400);

        $guideUser = $this->guideUserRepository->getCurrentGuideUser($guideUser->guide_id, $this->auth()->id, $guideSurvey->survey_id);

        if ($guideUser->answers != "") $body = $this->hasPreviousQuestion($guideUser->answers, $isValidRequest);

        else $body = $isValidRequest;

        $this->guideUserRepository->saveAnswer($guideUser, $body);
        return ['message' => 'La preguntas se guardaron correctmente'];
    }

    public function getQuestionInsideSection()
    {
        return $this->questionRepository->getQuestionBySection();
    }

    public function finalizeSurvey(string $surveyId)
    {
        $survey = $this->surveyRepository->findSurveyWithDetails($surveyId);
        if (!$survey) return new Exception('La series de cuestionarios que intentas finalizar no existe', 404);
        if($survey->status) return new Exception('La series de cuestionarios ya han sido finalizados', 404);

        $canFinishGuide = array_filter((array)[...$survey->guides], fn($guide) => $guide->pivot->status === GuideStatus::FINISHED->value);
        if(count($canFinishGuide) !== count($survey->guides)) return new Exception('La series de cuestionarios no se puede finalizar porque hay guías en proceso', 404);

        $survey = $this->surveyRepository->endSurvey($survey);
        return ['survey' => $survey];
    }

    public function setSurveyToUser()
    {
        $survey = $this->surveyRepository->getCurrentSurvey();
        if (!$survey) return new Exception('No hay encuestas disponibles', 404);

        $guides = json_decode(json_encode($survey->guides), true);

        $guide = array_filter($guides, fn ($guide) => $guide['pivot']['status'] === GuideStatus::INPROGRESS->value);

        if (count($guide) === 0) return new Exception('No hay encuestas disponibles', 400);

        $guide = collect(...$guide);

        $guideUser = $this->guideUserRepository->getCurrentGuideUser($guide['id'], $this->auth()->id, $survey->id);

        if (gettype($guideUser->answers) === 'array' && count($guideUser->answers) > 0) $guideUser = $this->guideUserRepository->clearOldAnswers($guideUser);

        return ['survey' => $guideUser, 'success' => true];
    }

    public function finalzeUserSurvey()
    {
        $survey = $this->guideSurveyRepository->findGuideInProgress();
        if (!$survey) return new Exception('La encuesta que intentas guardar no existe', 404);

        $userQualification = $this->calculateUserQualification(
            $this->guideUserRepository->getCurrentGuideUser($survey->guide_id, $this->auth()->id, $survey->survey_id)
        );

        $surveyUser = $this->guideUserRepository->finalizeGuideUser($survey->survey_id, $survey->guide_id, $this->auth()->id, $userQualification);
        return $surveyUser ? ['message' => 'La encuesta ha finalizado correctamente'] : new Exception('Parece que hubo un error al finalizar la encuesta', 500);
    }

    public function existSurveyInProgress()
    {
        $survey = $this->surveyRepository->getCurrentSurvey();
        if (!$survey) return new Exception('No hay encuestas disponibles', 400);

        $guideSurvey = $this->guideSurveyRepository->findGuideInProgress();

        if (!$guideSurvey) return new Exception('La encuesta ya ha sido contestada', 400);

        $guideUser = $this->guideUserRepository->getCurrentGuideUser($guideSurvey->guide_id, $this->auth()->id, $guideSurvey->survey_id);

        return $guideUser->status ? new Exception('La encuesta ya ha sido contestada', 400) : ['guide' => $guideUser];
    }

    public function finalizedGuideInsideSurvey(string $surveyId, string $guideId, int $totalUsers)
    {
        $totalSurveys = $this->guideUserRepository->countGudesUsersAvailable($surveyId, $guideId);

        if ($totalSurveys !== $totalUsers) return new Exception('No es posible finalizar la guía porque existen usuarios sin contestar la guia', 400);

        $guideSurvey = $this->guideSurveyRepository->findByGuideSurvey($surveyId, $guideId);

        if (!$guideSurvey) return new Exception('La guia no exite o no es valida', 404);
        if ($guideSurvey->status === GuideStatus::FINISHED->value) return new Exception('La guia ya ha sido finalizada', 400);
        if ($guideSurvey->status === GuideStatus::NOINITIALIZED->value) return new Exception('La guia no se puede finalizar', 400);

        $currentGuideSurvey =  $this->guideSurveyRepository->finalizedGuideSurvey($surveyId, $guideId);

        $nextGuideUser = $this->guideSurveyRepository->startNextGuide();

        return [
            'current_guide' => $currentGuideSurvey,
            'next_guide' => $nextGuideUser,
        ];
    }

    public function findOneSurveyWithGuides(string $surveyId, string $guideId)
    {
        // $survey = $this->guideUserRepository->findOne($surveyId);
        // if (!$survey) return new Exception('El cuestionario no existe o no es valido', 404);
        return $this->guideUserRepository->findUserGuideBySurvey($surveyId, $guideId);
    }

    public function getTotalUsersInSurvey(string $surveyId)
    {
        // return $this->surveyUserRepository->countSurveyUserAnswers($surveyId);
    }

    public function findSurveyByNameAndAreas(string $surveyId, string $guideId, string $name, string $areaId, string $subareaId)
    {
        return $this->guideUserRepository->searchByNameAndAreas($surveyId, $guideId, $name, $areaId, $subareaId);
    }

    public function getDetailsByUser(string $surveyId, string $userId, string $guideId)
    {
        $survey = $this->surveyRepository->findOne($surveyId);
        if (!$survey) return new Exception('El cuestionario no existe o no es valido', 404);
        $suerveyUser = $this->guideUserRepository->getDetailsByUser($surveyId, $userId, $guideId);
        return !$suerveyUser ? new Exception('La encuesta no esta disponible', 404) : $suerveyUser;
    }


    private function hasPreviousQuestion(mixed $answers, mixed $newBody): array
    {
        foreach ($answers as $index => $answer) {
            foreach ($newBody as $key => $newQuestion) {
                if ($answer['question_id'] == $newQuestion['question_id']) {
                    $answers[$index] = $newQuestion;
                    unset($newBody[$key]);
                }
            }
        }
        return [...$answers, ...$newBody];
    }

    private function validateCanFinishedQuestion(Section $section, bool $qualification)
    {
        return [
            'question_id' => '',
            'name' => $section->question,
            'category' => '',
            'section' => $section->id,
            'domain' => '',
            'dimension' => '',
            'qualification' => $qualification,
            'qualification_name' => '',
        ];
    }

    private function validateQuestions(mixed $body)
    {


        return array_map(function ($currentQuestion) {
            $question = $this->questionRepository->findOne($currentQuestion['question_id']);
            if (!$question) return false;
            return [
                'question_id' => $question->id,
                'name' => $question->name,
                'category' => [
                    'id' => $question->category->id ?? '',
                    'name' => $question->category->name ?? '',
                    'qualification' => $this->parseQualificationData(
                        $this->qualificationQuestionRepository->findQualificationByQuestion(
                            $currentQuestion['question_id'],
                            Category::class
                        )
                    ),
                ],
                'section' => [
                    'id' => $question->section->id ?? '',
                    'name' => $question->section->name ?? '',
                ],
                'domain' => [
                    'id' => $question->domain->id ?? '',
                    'name' => $question->domain->name ?? '',
                    'qualification' => $this->parseQualificationData(
                        $this->qualificationQuestionRepository->findQualificationByQuestion(
                            $currentQuestion['question_id'],
                            Domain::class
                        )
                    ),
                ],
                'dimension' => [
                    'id' => $question->dimension->id ?? '',
                    'name' => $question->dimension->name ?? ''
                ],
                'qualification' => $currentQuestion['qualification'],
                'qualification_data' => $this->questionRepository->getQualification($question) ?? ''
            ];
        }, (array) $body);
    }

    public function getLastSurveyByUser(string $userId)
    {
        // return $this->surveyUserRepository->findCurrentSurveyUser($userId);
    }

    public function attachGuidesToSurvey(Survey $survey, array $guidesId)
    {
        return $this->surveyRepository->setGuidesToNewSurvey($survey, $guidesId);
    }

    private function calculateUserQualification(GuideUser $guideUser): int
    {
        return array_reduce((array)$guideUser->answers, fn ($prev, $curr) => $prev + $curr['qualification']);
    }

    private function parseQualificationData(mixed $body)
    {
        if (!$body) return "";
        return [
            "id" => $body->qualificationable->id,
            "despicable" => $body->qualificationable->despicable,
            "low" => $body->qualificationable->low,
            "middle" => $body->qualificationable->middle,
            "high" => $body->qualificationable->high,
            "very_high" => $body->qualificationable->very_high,
        ];
    }
}
