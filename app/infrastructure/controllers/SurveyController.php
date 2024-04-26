<?php

namespace App\infrastructure\controllers;

use App\application\survey\SurveyUseCase;
use App\infrastructure\adapters\ExcelAdapter;
use App\infrastructure\adapters\OrientationTypes;
use App\infrastructure\adapters\PaperTypes;
use App\infrastructure\adapters\PdfAdapter;
use App\infrastructure\requests\survey\SaveQuestionRequest;
use App\kernel\controllers\Controller;
use Exception;

final class SurveyController extends Controller
{

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

	public function generateReportBy(string  $surveyId, string $guideId, string $userId)
	{
		try {
			$surveyUser = $this->surveyUseCase->findUserDetails($surveyId, $userId, $guideId);

			return $this->response($this->calculcateQualificationByCriteria('category', $surveyUser['guide_user']['answers']));

			$this->excelAdapter->setHeader([
				'<center><middle><b><style height="30" bgcolor="#059669" color="#FFFFFF">' . $surveyUser['guide_user']['guide']['name'] . '</style></b></middle></center>'
			])->mergeCellDocument('A1:E1');

			$this->excelAdapter->setHeader([
				'<b><center><middle><style height="30" border="#000000" bgcolor="#059669" color="#FFFFFF">Usuario:</middle></center></style></b>',
				"<middle><left>" . $surveyUser['guide_user']['user']['nombre']
					. " " . $surveyUser['guide_user']['user']['apellidoP'] . " " . $surveyUser['guide_user']['user']['apellidoM'] . "</left></middle>",
				null
			])->mergeCellDocument('B2:E2');

			$this->excelAdapter->setHeader([
				'<b><center><middle><style height="30" border="#000000" bgcolor="#059669" color="#FFFFFF">Área:</middle></center></style></b>',
				"<middle><left>" . $surveyUser['guide_user']['user']['area']['nombreArea'] . "</left></middle>",
				null
			])->mergeCellDocument('B3:E3');

			if ($surveyUser['guide_user']['guide']['gradable']) {
				$this->excelAdapter->setHeader([
					'<center><left><style height="30"></style></left></center>',
				]);
				$name = $this->getNameOfQualificationGuide($surveyUser['guide_user']['total'], $surveyUser['guide_user']['guide']['qualification']);
				$this->excelAdapter->setHeader([
					"<middle><b>CALIFICACIÓN DEL CUESTIONARIO:</b></middle>",
					"<middle><left>Pts:" . $surveyUser['guide_user']['total'] . "</left></middle>",
					'<middle><center><style height="30" bgcolor="' . $this->getColorByQualification($name) . '">' . $name . "</style></center></middle>",
				]);
				$this->excelAdapter->setHeader([
					'<center><left><style height="30"></style></left></center>',
				]);
				$qualification = $this->calculcateQualificationByCriteria('category', $surveyUser['guide_user']['answers']);
				foreach ($qualification as $key => $value) {
					$name = $this->getNameOfQualificationGuide($value['qualification'], (object)$value['qualifications']);
					$this->excelAdapter->setHeader([
						"<middle><b>CATEGORÍA - "  . $key . ": </b></middle>",
						"<middle><left>Pts:" . $value['qualification'] . "</left></middle>",
						'<middle><center><style height="30" bgcolor="' . $this->getColorByQualification($name) . '">' . $name . "</style></center></middle>",
					]);
				}
				$this->excelAdapter->setHeader([
					'<center><left><style height="30"></style></left></center>',
				]);
				$qualification = $this->calculcateQualificationByCriteria('domain', $surveyUser['guide_user']['answers']);
				foreach ($qualification as $key => $value) {
					$name = $this->getNameOfQualificationGuide($value['qualification'], (object)$value['qualifications']);
					$this->excelAdapter->setHeader([
						"<middle><b>DOMINIO - "  . $key . ":</b></middle>",
						"<middle><left>Pts:" . $value['qualification'] . "</left></middle>",
						'<middle><center><style height="30" bgcolor="' . $this->getColorByQualification($name) . '">' . $name . "</style></center></middle>",
					]);
				}
			}
			$this->excelAdapter->setHeader([
				'<center><left><style height="30"></style></left></center>',
			]);

			$this->setHeaderReport();

			$this->setBodyReport($surveyUser['guide_user']);
			$this->excelAdapter->generateReport();
		} catch (\Throwable $th) {
			$this->response(['message' => $th->getMessage()], 500);
		}
	}

	private function setHeaderReport()
	{
		$headers = [
			'<center><middle><b><style height="30" bgcolor="#059669" color="#FFFFFF">Pregunta</style></b></middle></center>',
			'<center><middle><b><style height="30" bgcolor="#059669" color="#FFFFFF">Calificación</style></b></middle></center>',
			'<center><middle><b><style height="30" bgcolor="#059669" color="#FFFFFF">Categoría</style></b></middle></center>',
			'<center><middle><b><style height="30" bgcolor="#059669" color="#FFFFFF">Dominio</style></b></middle></center>',
			'<center><middle><b><style height="30" bgcolor="#059669" color="#FFFFFF">Dimensión</style></b</middle></center>>'
		];
		$this->excelAdapter->setHeader($headers);
	}

	private function setBodyReport(mixed $surveyUser)
	{
		$this->excelAdapter->setData(array_map(function (int $key, array $answer,) {
			return [
				'<middle><style  height="30">' . $answer['name'] . '</style></middle>',
				"<center><b>" . $this->getNameOfQualifications($answer['qualification'], $answer['qualification_data'] ?? "") . "</b></center>",
				isset($answer['category']['name']) ? "<middle>" . $answer['category']['name'] . "</middle>"  : "",
				isset($answer['domain']['name']) ? "<middle>" . $answer['domain']['name'] . "</middle>"  : "",
				isset($answer['dimension']['name']) ? "<middle>" . $answer['dimension']['name'] . "</middle>"  : "",
			];
		}, (array) array_keys($surveyUser['answers']), array_values($surveyUser['answers'])));
	}
}
