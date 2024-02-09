<?php


namespace App\application\survey;

use Exception;

class SurveyUseCase
{

    public function __construct(private readonly SurveyService $surveyService)
    {
    }

    public function getAllSurveys()
    {
        return $this->surveyService->getSurvys();
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

    public function startSurveyByUser()
    {
        return $this->surveyService->setSurveyToUser();
    }

    public function finalizeSurveyByUser()
    {
        return $this->surveyService->finalzeUserSurvey();
    }

    public function getInProgressSurvey()
    {
        return $this->surveyService->existSurveyInProgress();
    }

    public function findSurveyById(string $surveyId)
    {
        $survey =  $this->surveyService->findOneSurvey($surveyId);
        return $survey ? ['survey' => $survey]  : new Exception('La encuesta no existe o no esta disponible', 404);
    }
}
