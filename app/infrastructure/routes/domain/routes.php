<?php

namespace App\infrastructure\routes\domain;

use Bramus\Router\Router;

use App\domain\domain\Domain;
use App\application\domain\DomainUseCase;
use App\infrastructure\controllers\DomainController;
use App\infrastructure\repositories\domain\DomainRepository;

function router(Router $router)
{
    $domainRepository   = new DomainRepository(new Domain);
    $domainseCase       = new DomainUseCase($domainRepository);
    $domainController   = new DomainController($domainseCase);

    $router->get('/', function ()  use ($domainController) {
        $domainController->getAllDomains();
    });
    $router->post('/create', function () use ($domainController) {
        $domainController->createDomain();
    });    
}
