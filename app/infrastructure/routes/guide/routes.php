<?php

namespace App\infrastructure\routes\guide;

use Bramus\Router\Router;

use App\domain\guide\Guide;
use App\application\guide\GuideUseCase;
use App\domain\section\Section;
use App\infrastructure\controllers\GuideController;
use App\infrastructure\repositories\guide\GuideRepository;
use App\infrastructure\repositories\section\SectionRepository;

function router(Router $router)
{
    $guideRepository   = new GuideRepository(new Guide);
    $sectionRepository = new SectionRepository(new Section);
    $guideseCase       = new GuideUseCase($guideRepository, $sectionRepository);
    $guideController   = new GuideController($guideseCase);

    $router->get('/', function ()  use ($guideController) {
        $guideController->getGuides();
    });

    $router->get('/search', function() use($guideController) {
        $guideController->getGuidesByCriteria();
    });

    $router->post('/create', function () use ($guideController) {
        // $middleware = new CreateResourceMiddleware(new SurveyRepository(new Survey));
        // $middleware->handle();
        $guideController->createGuide();
    });    

    // $router->get('/with/qualification', function () use ($domainController) {
    //     $domainController->getDomainsWithQualifications();
    // });
}
