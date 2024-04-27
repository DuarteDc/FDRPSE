<?php

namespace App\infrastructure\controllers;

use App\application\survey\SurveyUseCase;
use App\infrastructure\adapters\ExcelAdapter;
use App\infrastructure\adapters\OrientationTypes;
use App\infrastructure\adapters\PaperTypes;
use App\infrastructure\adapters\PdfAdapter;
use App\infrastructure\requests\survey\SaveQuestionRequest;
use App\kernel\controllers\Controller;
use App\shared\traits\CreateExcelReport;
use Exception;

final class SurveyController extends Controller
{

	use CreateExcelReport;

	public function __construct(private readonly SurveyUseCase $surveyUseCase, private readonly PdfAdapter $pdfAdapter, private readonly ExcelAdapter $excelAdapter)
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
		$guides = $this->request()->guides;
		$this->response($this->surveyUseCase->startNewSurvey($guides));
	}

	public function saveUserAnswers(string $surveyId, string $guideId)
	{
		$type = $this->get('type');
		//TODO fix save answer by guide
		$this->validate(SaveQuestionRequest::rules(), SaveQuestionRequest::messages());
		$this->response($this->surveyUseCase->saveAnswers($this->request()->questions, $type, $surveyId, $guideId));
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

	public function generateReportBy(string  $surveyId, string $guideId, string $userId)
	{

		$type = (string)$this->get('type');
		try {
			if ($type === 'user') {
				return $this->generateExcelReportByUser($surveyId, $guideId, $userId);
			}
			$this->generateExcelReportByArea($surveyId, $guideId, $userId);
		} catch (\Throwable $th) {
			$this->response(['message' => $th->getMessage()], 500);
		}
	}

	private function generateExcelReportByUser(string $surveyId, string $guideId, string $userId)
	{
		$surveyUser = $this->surveyUseCase->findUserDetails($surveyId, $userId, $guideId);

		if ($surveyUser instanceof Exception) {
			return $this->response($surveyUser);
		}

		['guide_user' => $guide] = $surveyUser;

		$this->createCommonHeaders($this->excelAdapter, $guide);
		$this->setBodyReport($guide);
		$this->excelAdapter->addNewSheet($guide['user']['nombre'] . " " . $guide['user']['apellidoP'] . " " . $guide['user']['apellidoM']);

		$this->excelAdapter->generateReport("Reporte por usuario");
	}

	private function generateExcelReportByArea(string $surveyId, string $guideId, string $areaId)
	{
		$survey = $this->surveyUseCase->getSurveyDetailByArea($surveyId, $guideId, $areaId);
		if ($survey instanceof Exception) {
			return $this->response($survey);
		}

		foreach ($survey as $key => $guide) {
			$this->createCommonHeaders($this->excelAdapter, $guide);
			$this->setBodyReport($guide);
			$this->excelAdapter->addNewSheet($guide['user']['nombre'] . " " . $guide['user']['apellidoP'] . " " . $guide['user']['apellidoM']);
		}

		$this->excelAdapter->generateReport("Reporte por area");
	}
}
