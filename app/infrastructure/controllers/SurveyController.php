<?php

namespace App\infrastructure\controllers;

use App\Http\Controllers\Controller;
use App\application\survey\SurveyUseCase;
use App\infrastructure\requests\survey\SaveQuestionRequest;

class SurveyController extends Controller
{

    public function __construct(private readonly SurveyUseCase $surveyUseCase)
    {
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
}
