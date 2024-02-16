<?php

namespace App\infrastructure\routes\domain;

use Bramus\Router\Router;

use App\domain\domain\Domain;
use App\application\domain\DomainUseCase;
use App\domain\survey\Survey;
use App\infrastructure\controllers\DomainController;
use App\infrastructure\middlewares\CreateResourceMiddleware;
use App\infrastructure\repositories\domain\DomainRepository;
use App\infrastructure\repositories\survey\SurveyRepository;

function router(Router $router)
{
    $domainRepository   = new DomainRepository(new Domain);
    $domainseCase       = new DomainUseCase($domainRepository);
    $domainController   = new DomainController($domainseCase);

    $router->get('/', function ()  use ($domainController) {
        $domainController->getAllDomains();
    });
    $router->post('/create', function () use ($domainController) {
        // $middleware = new CreateResourceMiddleware(new SurveyRepository(new Survey));
        // $middleware->handle();
        $domainController->createDomain();
    });    

    $router->get('/with/qualification', function () use ($domainController) {
        $domainController->getDomainsWithQualifications();
    });
}
