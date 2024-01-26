<?php

namespace App\infrastructure\routes\section;

use Bramus\Router\Router;

use App\domain\section\Section;
use App\application\section\SectionUseCase;
use App\infrastructure\controllers\SectionController;
use App\infrastructure\repositories\section\SectionRepository;



function router(Router $router)
{
    $sectionRepository  = new SectionRepository(new Section);
    $sectionUseCase     = new SectionUseCase($sectionRepository);
    $sectionController  = new SectionController($sectionUseCase);

    $router->get('/', function ()  use ($sectionController) {
        $sectionController->getAllSections();
    });
    $router->post('/create', function () use ($sectionController) {
        $sectionController->createSection();
    });    
}
