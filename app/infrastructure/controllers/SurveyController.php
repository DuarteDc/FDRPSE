<?php

namespace App\infrastructure\controllers;

use App\Http\Controllers\Controller;
use App\application\survey\SurveyUseCase;
use App\domain\section\Section;

class SurveyController extends Controller
{

    public function __construct(private readonly SurveyUseCase $surveyUseCase)
    {
    }

    public function startSurvey()
    {
        $this->response($this->surveyUseCase->startNewSurvey());
    }

    public function saveUserAnswers(string $surveyId) {
        //TODO request to insert questions
        $this->response($this->surveyUseCase->saveAnswers($surveyId, $this->request()));
    }

}
