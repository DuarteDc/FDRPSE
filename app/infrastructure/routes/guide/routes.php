<?php

declare(strict_types=1);

namespace App\infrastructure\routes\guide;

use App\application\guide\GuideUseCase;

use App\domain\guide\Guide;
use App\domain\section\Section;
use App\infrastructure\controllers\GuideController;
use App\infrastructure\repositories\guide\GuideRepository;
use App\infrastructure\repositories\section\SectionRepository;
use Bramus\Router\Router;

function router(Router $router)
{
	$guideRepository   = new GuideRepository(new Guide());
	$sectionRepository = new SectionRepository(new Section());
	$guideseCase       = new GuideUseCase($guideRepository, $sectionRepository);
	$guideController   = new GuideController($guideseCase);

	$router->get('/', function () use ($guideController) {
		$guideController->getGuides();
	});

	$router->get('/search', function () use ($guideController) {
		$guideController->getGuidesByCriteria();
	});

	$router->get('/{surveyId}/survey/{guideId}', function (string $surveyId, string $guideId) use ($guideController) {
		$guideController->showGuideBySurvey($surveyId, $guideId);
	});

	$router->post('/create', function () use ($guideController) {
		// $middleware = new CreateResourceMiddleware(new SurveyRepository(new Survey));
		// $middleware->handle();
		$guideController->createGuide();
	});

	$router->get('/{id}/detail', function (string $id) use ($guideController) {
		$guideController->getGuideDetail($id);
	});

	$router->get('/{id}', function (string $id) use ($guideController) {
		$guideController->showGuide($id);
	});


	$router->delete('/disable/{guideId}', function (string $guideId) use ($guideController) {
		$guideController->disableGudie($guideId);
	});

	$router->patch('/enable/{guideId}', function (string $guideId) use ($guideController) {
		$guideController->enableGudie($guideId);
	});
}
