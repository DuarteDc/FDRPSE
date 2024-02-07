<?php

namespace App\application\survey;

use Exception;
use App\Traits\Auth;
use App\domain\survey\Survey;
use App\domain\survey\SurveyRepository;
use App\domain\surveyUser\SurveyUserRepository;
use App\domain\question\QuestionRepository;

class SurveyService
{
    use Auth;

    public function __construct(private readonly SurveyRepository $surveyRepository, private readonly SurveyUserRepository $surveyUserRepository, private readonly QuestionRepository $questionRepository)
    {
    }

    public function startSurvey()
    {
        if (!$this->surveyRepository->canStartNewSurvey()) return new Exception('Hay una encuesta en progreso por lo que no se puede comenzar la nueva encuesta', 400);
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

        if ($surveyUser->answers != "")  $body = $this->hasPreviousQuestion($surveyUser->answers, $isValidRequest);

        else $body = $isValidRequest;

        $this->surveyUserRepository->saveAnswer($surveyUser, $body);
        return ['message' => 'La preguntas se guardaron correctmente'];
    }

    public function getQuestionInsideSection()
    {
        return $this->questionRepository->getQuestionBySection();
    }

    public function changeToPendingStatus() 
    {
        
    }

    private function hasPreviousQuestion(mixed $answers, mixed $newBody): array
    {

        $answers = json_decode($answers); 

        foreach ($answers as $index => $answer) {
            foreach ($newBody as $key => $newQuestion) {
                if($answer->question_id == $newQuestion['question_id']) {
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
                'qualification' => $currentQuestion['qualification']
            ];
        }, (array) $body->questions);
    }
}
