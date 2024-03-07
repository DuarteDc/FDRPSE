<?php

namespace App\application\survey;

use Exception;
use App\kernel\authentication\Auth;

use App\domain\survey\Survey;
use App\domain\survey\SurveyRepository;
use App\domain\surveyUser\SurveyUserRepository;
use App\domain\question\QuestionRepository;
use App\domain\surveyUser\SurveyUser;

class SurveyService
{
    use Auth;

    public function __construct(private readonly SurveyRepository $surveyRepository, private readonly SurveyUserRepository $surveyUserRepository, private readonly QuestionRepository $questionRepository)
    {
    }

    public function getSurvys()
    {
        return $this->surveyRepository->findAllSurveys();
    }

    public function startSurvey()
    {
        // if (!$this->surveyRepository->canStartNewSurvey()) return new Exception('Hay un cuestionatio en progreso por lo que no se puede comenzar la nueva encuesta', 400);
        // if ($this->questionRepository->countQuestions() <= 0) return new Exception('No se puede comenzar el cuestionario porque no existen preguntas', 400);
        return $this->surveyRepository->create(['start_date' => date('Y-m-d\TH:i:s.000'), 'status' => Survey::PENDING]);
    }

    public function attachDataUserAndSurvey(string $surveyUserId, string $surveyId, string $userId)
    {
        $this->surveyUserRepository->setSurvey($surveyUserId, $surveyId);
        $this->surveyUserRepository->setUser($surveyUserId, $userId);
    }

    public function saveAnswersByUser(mixed $body)
    {
        $survey = $this->surveyRepository->getCurrentSurvey();
        if (!$survey) return new Exception('Parece que hubo un error al registar la respusta', 400);
        $isValidRequest = $this->validateQuestions($body);

        if (in_array(false, $isValidRequest)) return new Exception('Las preguntas que intentas guardar no exiten', 400);

        $surveyUser = $this->surveyUserRepository->getCurrentSurveyUser($survey->id, $this->auth()->id);

        if ($surveyUser->answers != "") $body = $this->hasPreviousQuestion($surveyUser->answers, $isValidRequest);

        else $body = $isValidRequest;

        $this->surveyUserRepository->saveAnswer($surveyUser, $body);
        return ['message' => 'La preguntas se guardaron correctmente'];
    }

    public function getQuestionInsideSection()
    {
        return $this->questionRepository->getQuestionBySection();
    }

    public function setSurveyToUser()
    {
        $survey = $this->surveyRepository->getCurrentSurvey();
        if (!$survey) return new Exception('No hay encuestas disponibles', 404);
        return ['survey' => $this->surveyUserRepository->getCurrentSurveyUser($survey->id, $this->auth()->id), 'success' => true];
    }

    public function finalzeUserSurvey()
    {
        $survey = $this->surveyRepository->getCurrentSurvey();
        if (!$survey) return new Exception('La encuesta que intentas guardar no existe', 404);
        $userQualification = $this->calculateUserQualification($this->surveyUserRepository->getCurrentSurveyUser($survey->id, $this->auth()->id));
        $surveyUser = $this->surveyUserRepository->finalizeSurveyUser($survey->id, $this->auth()->id, $userQualification);
        return $surveyUser ? ['message' => 'La encuesta ha finalizado correctamente'] : new Exception('Parece que hubo un error al finalizar la encuesta', 500);
    }

    public function existSurveyInProgress()
    {
        $survey = $this->surveyRepository->getCurrentSurvey();
        if (!$survey) return new Exception('No hay encuestas disponibles', 400);
        $surveyUser = $this->surveyUserRepository->canAvailableSurveyPerUSer($survey->id, $this->auth()->id);
        if (!$surveyUser) return ['survey' => $survey];
        return $surveyUser->status ? new Exception('La encuesta ya ha sido contestada', 400) : ['survey' => $survey];
    }

    public function findOneSurvey(string $surveyId)
    {
        return $this->surveyRepository->findOne($surveyId);
    }

    public function getSurveyDetails(string $surveyId)
    {
        $suervey = $this->surveyRepository->findOne($surveyId);
        if (!$suervey) return new Exception('El cuestionario no existe o no es valido', 404);
        return $this->surveyUserRepository->getDetailsSurveyUser($surveyId);
    }

    public function getTotalUsersInSurvey(string $surveyId)
    {
        return $this->surveyUserRepository->countSurveyUserAnswers($surveyId);
    }

    public function findSurveyByName(string $surveyId, string $name, string $areaId)
    {
        return $this->surveyUserRepository->searchByName($surveyId, $name, $areaId);
    }

    public function getDetailsByUser(string $surveyId, string $userId)
    {
        $survey = $this->surveyRepository->findOne($surveyId, $userId);
        if (!$survey) return new Exception('El cuestionario no existe o no es valido', 404);
        $suerveyUser = $this->surveyUserRepository->getDetailsByUser($surveyId, $userId);
        return !$suerveyUser ? new Exception('La encuesta no esta disponible', 404) : $suerveyUser;
    }

    public function endSurvey(string $suerveyId)
    {
        $survey = $this->surveyRepository->endSurvey($suerveyId);
        return ['survey' => $survey];
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
                ],
                'section' => [
                    'id' => $question->section->id ?? '',
                    'name' => $question->section->name ?? '',
                ],
                'domain' => [
                    'id' => $question->domain->id ?? '',
                    'name' => $question->domain->name ?? '',
                ],
                'dimension' => [
                    'id' => $question->dimension->id ?? '',
                    'name' => $question->dimension->name ?? ''
                ],
                'qualification' => $currentQuestion['qualification'],
                'qualification_name' => $this->questionRepository->getQualification($question)
            ];
        }, (array) $body->questions);
    }

    public function getLastSurveyByUser(string $userId) {
        return $this->surveyUserRepository->findCurrentSurveyUser($userId);
    }

    private function calculateUserQualification(SurveyUser $surveyUser): int
    {
        return array_reduce($surveyUser->answers, fn ($prev, $curr) => $prev + $curr['qualification']);
    }
}
