<?php

namespace App\infrastructure\routes\qualification;

use Bramus\Router\Router;

use App\domain\qualification\Qualification;
use App\application\qualification\QualificationUseCase;
use App\infrastructure\controllers\QualificationController;
use App\infrastructure\repositories\qualification\QualificationRepository;

function router(Router $router)
{
    $qualificationRepository   = new QualificationRepository(new Qualification);
    $qualificationseCase       = new QualificationUseCase($qualificationRepository);
    $qualificationController   = new QualificationController($qualificationseCase);

    $router->get('/', function ()  use ($qualificationController) {
        $qualificationController->getAllQualifications();
    });
}
