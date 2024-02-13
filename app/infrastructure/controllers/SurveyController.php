<?php

namespace App\infrastructure\controllers;

use App\kernel\controllers\Controller;
use App\application\survey\SurveyUseCase;
use App\infrastructure\requests\survey\SaveQuestionRequest;

class SurveyController extends Controller
{

    public function __construct(private readonly SurveyUseCase $surveyUseCase)
    {
    }

    public function getAllSurveys()
    {
        $this->response($this->surveyUseCase->getAllSurveys());
    }

    public function startSurvey()
    {
        $this->response($this->surveyUseCase->startNewSurvey());
    }

    public function saveUserAnswers()
    {
        $this->validate(SaveQuestionRequest::rules(), SaveQuestionRequest::messages());
        $this->response($this->surveyUseCase->saveAnswers($this->request()));
    }

    public function startSurveyByUser()
    {
        $this->response($this->surveyUseCase->startSurveyByUser());
    }

    public function finishUserSurvey()
    {
        $this->response($this->surveyUseCase->finalizeSurveyByUser());
    }

    public function getCurrentSurvey()
    {
        $this->response($this->surveyUseCase->getInProgressSurvey());
    }

    public function getSurveyById(string $surveyId)
    {
        $this->response($this->surveyUseCase->getOneSurvey($surveyId));
    }

    public function findSurveyDetailByUserName(string $surveyId)
    {
        $name = $this->get('name');
        $name = (string)trim(mb_strtoupper($name));
        $this->response($this->surveyUseCase->findSurveyByName($surveyId, $name));
    }
}
