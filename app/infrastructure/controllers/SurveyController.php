<?php

namespace App\infrastructure\controllers;

use Exception;
use App\kernel\controllers\Controller;
use App\application\survey\SurveyUseCase;
use App\infrastructure\adapters\PdfAdapter;
use App\infrastructure\adapters\PaperTypes;
use App\infrastructure\adapters\OrientationTypes;
use App\infrastructure\requests\survey\SaveQuestionRequest;

class SurveyController extends Controller
{

    public function __construct(private readonly SurveyUseCase $surveyUseCase, private readonly PdfAdapter $pdfAdapter)
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

    public function generateReportByUser(string $surveyId, string $userId)
    {
        $surveyUser = $this->surveyUseCase->findUserDetails($surveyId, $userId);
        if ($surveyUser instanceof Exception) return $this->response($surveyUser);
        $view = $this->renderBufferView('pdf-user-answers', $surveyUser);
        $this->pdfAdapter->generatePDF($view, PaperTypes::Letter, OrientationTypes::Portrait, 'Acuse de entraga');
    }
}
