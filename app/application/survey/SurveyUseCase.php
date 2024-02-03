<?php


namespace App\application\survey;

class SurveyUseCase
{

    public function __construct(private readonly SurveyService $surveyService)
    {
    }

    public function startNewSurvey()
    {
        return $this->surveyService->startSurvey();
    }

    public function saveAnswers(mixed $body)
    {
        return $this->surveyService->saveAnswersByUser($body);
    }

    public function getQuestionsByUser()
    {
        return $this->surveyService->getQuestionInsideSection();
    }
}
