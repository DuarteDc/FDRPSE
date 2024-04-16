<?php

namespace App\infrastructure\routes\guide;

use App\application\guide\GuideUseCase;

use App\domain\guide\Guide;
use App\domain\section\Section;
use App\domain\survey\Survey;
use App\infrastructure\controllers\GuideController;
use App\infrastructure\middlewares\CreateResourceMiddleware;
use App\infrastructure\middlewares\HasAdminRoleMiddleware;
use App\infrastructure\repositories\guide\GuideRepository;
use App\infrastructure\repositories\section\SectionRepository;
use App\infrastructure\repositories\survey\SurveyRepository;
use Bramus\Router\Router;

function router(Router $router)
{
	$hasAdminRole 	   = new HasAdminRoleMiddleware();

	$guideRepository   = new GuideRepository(new Guide());
	$sectionRepository = new SectionRepository(new Section());
	$guideseCase       = new GuideUseCase($guideRepository, $sectionRepository);
	$guideController   = new GuideController($guideseCase);


	$router->get('/', function () use ($guideController, $hasAdminRole) {
		$hasAdminRole->handle();
		$guideController->getGuides();
	});

	$router->get('/search', function () use ($guideController, $hasAdminRole) {
		$hasAdminRole->handle();
		$guideController->getGuidesByCriteria();
	});

	$router->get('/{surveyId}/survey/{guideId}', function (string $surveyId, string $guideId) use ($guideController, $hasAdminRole) {
		$hasAdminRole->handle();
		$guideController->showGuideBySurvey($surveyId, $guideId);
	});

	$router->post('/create', function () use ($guideController, $hasAdminRole) {
		$hasAdminRole->handle();
		$middleware = new CreateResourceMiddleware(new SurveyRepository(new Survey));
		$middleware->handle();
		$guideController->createGuide();
	});

	$router->get('/{id}/detail', function (string $id) use ($guideController) {
		$guideController->getGuideDetail($id);
	});

	$router->get('/{id}', function (string $id) use ($guideController, $hasAdminRole) {
		$hasAdminRole->handle();
		$guideController->showGuide($id);
	});


	$router->delete('/disable/{guideId}', function (string $guideId) use ($guideController, $hasAdminRole) {
		$hasAdminRole->handle();
		$guideController->disableGudie($guideId);
	});

	$router->patch('/enable/{guideId}', function (string $guideId) use ($guideController, $hasAdminRole) {
		$hasAdminRole->handle();
		$guideController->enableGudie($guideId);
	});
}
