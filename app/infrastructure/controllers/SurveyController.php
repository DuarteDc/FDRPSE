<?php

namespace App\infrastructure\controllers;

use App\Http\Controllers\Controller;
use App\application\survey\SurveyUseCase;
use App\domain\section\Section;
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

    public function saveUserAnswers(string $surveyId)
    {
        $this->validate(SaveQuestionRequest::rules(), SaveQuestionRequest::messages());
        $this->response($this->surveyUseCase->saveAnswers($surveyId, $this->request()));
    }
}
