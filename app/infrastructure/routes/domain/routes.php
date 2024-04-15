<?php

declare(strict_types=1);

namespace App\infrastructure\routes\domain;

use App\application\domain\DomainUseCase;

use App\domain\domain\Domain;
use App\domain\survey\Survey;
use App\infrastructure\controllers\DomainController;
use App\infrastructure\middlewares\CreateResourceMiddleware;
use App\infrastructure\repositories\domain\DomainRepository;
use App\infrastructure\repositories\survey\SurveyRepository;
use Bramus\Router\Router;

function router(Router $router)
{
	$domainRepository = new DomainRepository(new Domain());
	$domainseCase = new DomainUseCase($domainRepository);
	$domainController = new DomainController($domainseCase);

	$router->get('/', function () use ($domainController) {
		$domainController->getAllDomains();
	});

	$router->post('/create', function () use ($domainController) {
		$middleware = new CreateResourceMiddleware(new SurveyRepository(new Survey()));
		$middleware->handle();
		$domainController->createDomain();
	});


	$router->get('/with/qualifications/{categoryId}', function (string $domainId) use ($domainController) {
		// $checkRole->handle();
		$domainController->getDomainWithQualifications($domainId);
	});

	$router->get('/with/qualification', function () use ($domainController) {
		$domainController->getDomainsWithQualifications();
	});

	$router->post('/add/qualification/{domainId}', function (string $domainId) use ($domainController) {
		$domainController->addNewQualification($domainId);
	});
}
