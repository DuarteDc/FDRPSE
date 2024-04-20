<?php

namespace App\infrastructure\controllers;

use App\application\survey\SurveyUseCase;
use App\infrastructure\adapters\OrientationTypes;
use App\infrastructure\adapters\PaperTypes;
use App\infrastructure\adapters\PdfAdapter;
use App\infrastructure\requests\survey\SaveQuestionRequest;
use App\kernel\controllers\Controller;
use Exception;

final class SurveyController extends Controller
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
		// $this->validate(StartNewSurveyRequest::rules(), StartNewSurveyRequest::messages());
		$guides = $this->request()->guides;
		$this->response($this->surveyUseCase->startNewSurvey($guides));
	}

	public function saveUserAnswers()
	{
		$type = $this->get('type');
		$this->validate(SaveQuestionRequest::rules(), SaveQuestionRequest::messages());
		$this->response($this->surveyUseCase->saveAnswers($this->request()->questions, $type));
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

	public function findSurveyDetailByUserName(string $surveyId, string $guideId)
	{
		$name      = (string) $this->get('name') ?? '';
		$areaId    = (string) $this->get('area') ?? '';
		$subareaId = (string) $this->get('subarea') ?? '';
		$name      = trim(mb_strtoupper($name));
		$this->response($this->surveyUseCase->findSurveyByName($surveyId, $guideId, $name, $areaId, $subareaId));
	}

	public function getDetailsByUser(string $surveyId, string $userId, string $guideId)
	{
		$this->response($this->surveyUseCase->findUserDetails($surveyId, $userId, $guideId));
	}

	public function getTotalUserInSurvey()
	{
		$this->response($this->surveyUseCase->getUserWithoutSurvey());
	}

	public function finalizeSurvey(string $surveyId)
	{
		$this->response($this->surveyUseCase->finalizeSurvey($surveyId));
	}

	public function finalizeGuideSurvey(string $surveyId, string $guideId)
	{
		$this->response($this->surveyUseCase->tryToFinalizeGuide($surveyId, $guideId));
	}

	public function generateReportByUser()
	{
		try {
			$surveyUser = $this->surveyUseCase->getDataToGenerateSurveyUserResume($this->auth()->id);
			if ($surveyUser instanceof Exception) {
				return $this->response($surveyUser);
			}
			$view = $this->renderBufferView('pdf-user-answers', $surveyUser);
			$this->pdfAdapter->generatePDF($view, PaperTypes::Letter, OrientationTypes::Portrait, 'Acuse de entraga');
		} catch (\Throwable $th) {
			$this->response(new Exception('No hay reportes disponibles', 400));
		}
	}

	public function pauseGuideBySurvey(string $surveyId, string $guideId)
	{
		$status = (int) $this->get('status');

		$this->response($this->surveyUseCase->changeGuideStatusToPaused($surveyId, $guideId, $status));
	}

	public function existInProgressGuideUser(string $surveyId, string $guideId)
	{
		$this->response($this->surveyUseCase->hasProgresGuide($surveyId, $guideId));
	}

	public function startGuide(string $surveyId, string $guideId)
	{
		$this->response($this->surveyUseCase->startGuideInsideSurvey($surveyId, $guideId));
	}
}
