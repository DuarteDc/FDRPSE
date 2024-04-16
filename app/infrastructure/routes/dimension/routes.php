<?php

namespace App\infrastructure\routes\dimension;

use App\application\dimension\DimensionUseCase;

use App\domain\dimension\Dimension;
use App\domain\survey\Survey;
use App\infrastructure\controllers\DimensionController;
use App\infrastructure\middlewares\CreateResourceMiddleware;
use App\infrastructure\middlewares\HasAdminRoleMiddleware;
use App\infrastructure\repositories\dimension\DimensionRepository;
use App\infrastructure\repositories\survey\SurveyRepository;
use Bramus\Router\Router;

function router(Router $router)
{
	$dimensionRepository = new DimensionRepository(new Dimension());
	$dimensionUseCase    = new DimensionUseCase($dimensionRepository);
	$dimensionController = new DimensionController($dimensionUseCase);

	$hasAdminRole = new HasAdminRoleMiddleware();
	$middleware   = new CreateResourceMiddleware(new SurveyRepository(new Survey()));

	$router->get('/', function () use ($dimensionController) {
		$dimensionController->getAllDimensions();
	});

	$router->post('/create', function () use ($dimensionController, $hasAdminRole, $middleware) {
		$hasAdminRole->handle();
		$middleware->handle();
		$dimensionController->createDimension();
	});

	$router->patch('/update/{dimensionId}', function (string $dimensionId) use (
		$dimensionController,
		$hasAdminRole,
		$middleware
	) {
		$hasAdminRole->handle();
		$middleware->handle();
		$dimensionController->updateDimension($dimensionId);
	});

	$router->delete('/delete/{dimensionId}', function (string $dimensionId) use (
		$dimensionController,
		$hasAdminRole,
		$middleware
	) {
		$hasAdminRole->handle();
		$middleware->handle();
		$dimensionController->deleteDimension($dimensionId);
	});
}
