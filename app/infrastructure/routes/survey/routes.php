<?php

namespace App\infrastructure\routes\survey;

use App\application\survey\SurveyService;
use Bramus\Router\Router;

use App\domain\survey\Survey;
use App\application\survey\SurveyUseCase;
use App\domain\area\Area;
use App\domain\question\Question;
use App\domain\surveyUser\SurveyUser;
use App\domain\user\User;
use App\infrastructure\controllers\SurveyController;
use App\infrastructure\adapters\PdfAdapter;
use App\infrastructure\repositories\area\AreaRepository;
use App\infrastructure\repositories\question\QuestionRepository;
use App\infrastructure\repositories\survey\SurveyRepository;
use App\infrastructure\repositories\surveyUser\SurveyUserRepository;
use App\infrastructure\repositories\user\UserRepository;

function router(Router $router)
{
    $surveyRepository       = new SurveyRepository(new Survey);
    $surveyUserRepository   = new SurveyUserRepository(new SurveyUser);
    $questionRepository     = new QuestionRepository(new Question);
    $userRepository         = new UserRepository(new User);
    $surveyService          = new SurveyService($surveyRepository, $surveyUserRepository, $questionRepository);
    $areaRepository         = new AreaRepository(new Area);
    $surveyUseCase          = new SurveyUseCase($surveyService, $userRepository, $areaRepository);
    $pdfAdapter             = new PdfAdapter;
    $surveyController       = new SurveyController($surveyUseCase, $pdfAdapter);

    $router->get('/', function ()  use ($surveyController) {
        $surveyController->getAllSurveys();
    });

    $router->post('/start', function () use ($surveyController) {
        $surveyController->startSurvey();
    });    

    $router->post('/save-questions', function () use ($surveyController) {
        $surveyController->saveUserAnswers();
    });    
    
    $router->post('/start-user', function () use ($surveyController) {
        $surveyController->startSurveyByUser();
    });    
    
    $router->post('/end-user', function () use ($surveyController) {
        $surveyController->finishUserSurvey();
    });    
    
    $router->get('/current', function () use($surveyController) {
        $surveyController->getCurrentSurvey();
    });
    
    $router->get('/details/{surveId}/{userId}', function (string $id, string $userId) use($surveyController) {
        $surveyController->getDetailsByUser($id, $userId);
    });
    
    $router->get('/report', function () use($surveyController) {
        $surveyController->generateReportByUser();
    });

    $router->get('/total-users', function () use($surveyController) {
        $surveyController->getTotalUserInSurvey();
    });

    $router->get('/{surveyId}/find-by', function (string $surveyId) use($surveyController) {
        $surveyController->findSurveyDetailByUserName($surveyId);
    });    
    
    $router->get('/{id}', function (string $id) use($surveyController) {
        $surveyController->getSurveyById($id);
    });
    
    $router->post('/end/{id}', function (string $id) use($surveyController) {
        $surveyController->finalizeSurvey($id);
    });
    

}

