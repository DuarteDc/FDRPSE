<?php

declare(strict_types=1);

namespace App\infrastructure\routes\qualification;

use App\application\qualification\QualificationUseCase;

use App\domain\qualification\Qualification;
use App\infrastructure\controllers\QualificationController;
use App\infrastructure\repositories\qualification\QualificationRepository;
use Bramus\Router\Router;

function router(Router $router)
{
	$qualificationRepository = new QualificationRepository(new Qualification());
	$qualificationseCase     = new QualificationUseCase($qualificationRepository);
	$qualificationController = new QualificationController($qualificationseCase);

	$router->get('/', function () use ($qualificationController) {
		$qualificationController->getAllQualifications();
	});
}
