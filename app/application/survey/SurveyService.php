<?php

namespace App\application\survey;

use App\domain\question\QuestionRepository;
use App\domain\survey\Survey;
use App\domain\survey\SurveyRepository;
use App\domain\surveyUser\SurveyUserRepository;
use Exception;

class SurveyService
{

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

    public function saveAnswersByUser(string $surveyId, mixed $body)
    {
        $survey = $this->surveyRepository->findOne($surveyId);
        if (!$survey) return new Exception('Parece que hubo un error al registar la respusta');
        $isValidRequest = $this->validateQuestions($body);

        if (in_array(false, $isValidRequest)) return new Exception('Las preguntas que intentas guardar no exiten', 400);

        $surveyUser = $this->surveyUserRepository->getCurrentSurveyUser($surveyId, 2);

        return $this->surveyUserRepository->saveAnswer($surveyUser, $isValidRequest);
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
                    'id' => $question->section->id,
                    'name' => $question->section->name,
                ],
                'domain' => [
                    'id' => $question->domain->id ?? '',
                    'name' => $question->domain->id ?? '',
                ],
                'dimension' => [
                    'id' => $question->dimension->id ?? '',
                    'name' => $question->dimension->name ?? ''
                ],
                'qualification' => $currentQuestion['qualification']
            ];
        }, (array) $body);
    }
}
