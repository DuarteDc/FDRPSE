<?php

namespace App\infrastructure\controllers;

use Exception;
use App\kernel\controllers\Controller;
use App\application\survey\SurveyUseCase;
use App\infrastructure\adapters\PdfAdapter;
use App\infrastructure\adapters\PaperTypes;
use App\infrastructure\adapters\OrientationTypes;
use App\infrastructure\requests\survey\SaveQuestionRequest;
use App\infrastructure\requests\survey\StartNewSurveyRequest;

class SurveyController extends Controller
{

    public function __construct(private readonly SurveyUseCase $surveyUseCase, private readonly PdfAdapter $pdfAdapter)
    {
    }

    public function getAllSurveys()
    {
        $page = (int) $this->get('page');
        $this->response($this->surveyUseCase->getAllSurveys($page));
    }

    public function showSurvey(string $surveyId)
    {
        $this->response($this->surveyUseCase->getSurveyById($surveyId));
    }

    public function startSurvey()
    {
        $this->validate(StartNewSurveyRequest::rules(), StartNewSurveyRequest::messages());
        $guides = $this->request()->guides;
        $this->response($this->surveyUseCase->startNewSurvey($guides));
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
        $name = (string) $this->get('name') ?? '';
        $areaId = $this->get('area') ?? '';
        $name = trim(mb_strtoupper($name));
        $this->response($this->surveyUseCase->findSurveyByName($surveyId, $name, $areaId));
    }

    public function getDetailsByUser(string $surveyId,  string $userId)
    {
        $this->response($this->surveyUseCase->findUserDetails($surveyId, $userId));
    }

    public function getTotalUserInSurvey()
    {
        $this->response($this->surveyUseCase->getUserWithoutSurvey());
    }

    public function finalizeSurvey(string $surveyId)
    {
        $this->response($this->surveyUseCase->finalizeSurvey($surveyId));
    }

    public function generateReportByUser()
    {
        $surveyUser = $this->surveyUseCase->getDataToGenerateSurveyUserResume($this->auth()->id);
        if ($surveyUser instanceof Exception) return $this->response($surveyUser);
        $view = $this->renderBufferView('pdf-user-answers', $surveyUser);
        $this->pdfAdapter->generatePDF($view, PaperTypes::Letter, OrientationTypes::Portrait, 'Acuse de entraga');
    }
}
