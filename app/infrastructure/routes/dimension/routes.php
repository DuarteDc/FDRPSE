<?php

declare(strict_types=1);

namespace App\infrastructure\routes\dimension;

use App\application\dimension\DimensionUseCase;

use App\domain\dimension\Dimension;
use App\domain\survey\Survey;
use App\infrastructure\controllers\DimensionController;
use App\infrastructure\middlewares\CreateResourceMiddleware;
use App\infrastructure\repositories\dimension\DimensionRepository;
use App\infrastructure\repositories\survey\SurveyRepository;
use Bramus\Router\Router;

function router(Router $router)
{
	$dimensionRepository = new DimensionRepository(new Dimension());
	$dimensionUseCase = new DimensionUseCase($dimensionRepository);
	$dimensionController = new DimensionController($dimensionUseCase);

	$router->get('/', function () use ($dimensionController) {
		$dimensionController->getAllDimensions();
	});

	$router->post('/create', function () use ($dimensionController) {
		$middleware = new CreateResourceMiddleware(new SurveyRepository(new Survey()));
		$middleware->handle();
		$dimensionController->createDimension();
	});
}
