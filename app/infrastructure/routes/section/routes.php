<?php

namespace App\infrastructure\routes\section;

use Bramus\Router\Router;

use App\domain\section\Section;
use App\application\section\SectionUseCase;
use App\domain\survey\Survey;
use App\infrastructure\controllers\SectionController;
use App\infrastructure\middlewares\CreateResourceMiddleware;
use App\infrastructure\repositories\section\SectionRepository;
use App\infrastructure\repositories\survey\SurveyRepository;

function router(Router $router)
{
    $sectionRepository  = new SectionRepository(new Section);
    $sectionUseCase     = new SectionUseCase($sectionRepository);
    $sectionController  = new SectionController($sectionUseCase);

    $router->get('/', function ()  use ($sectionController) {
        $sectionController->getAllSections();
    });

    $router->get('/questions', function () use ($sectionController) {
        $sectionController->getSectionsWithQuestions();
    });    

    $router->get('/questions/by', function () use ($sectionController) {
        $sectionController->getSectionsBy();
    });    

    $router->get('/questions/{sectionId}', function (string $sectionId) use ($sectionController) {
        $sectionController->getSectionWithQuestions($sectionId);
    });    

    $router->get('/{id}', function (string $id) use ($sectionController) {
        $sectionController->getOneSection($id);
    });
    
    $router->post('/create', function () use ($sectionController) {
        // $middleware = new CreateResourceMiddleware(new SurveyRepository(new Survey));
        // $middleware->handle();
        $sectionController->createSection();
    });    

    $router->post('/details', function () use ($sectionController) {
        $sectionController->getSectionsWithHisQuestions();
    });    
}
