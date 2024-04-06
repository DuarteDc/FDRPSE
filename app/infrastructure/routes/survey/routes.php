<?php

namespace App\infrastructure\routes\survey;

use App\application\survey\SurveyService;
use Bramus\Router\Router;

use App\domain\survey\Survey;
use App\application\survey\SurveyUseCase;
use App\domain\area\Area;
use App\domain\guide\Guide;
use App\domain\guideSurvey\GuideSurvey;
use App\domain\question\Question;
use App\domain\guideUser\GuideUser;
use App\domain\user\User;
use App\infrastructure\controllers\SurveyController;
use App\infrastructure\adapters\PdfAdapter;
use App\infrastructure\repositories\area\AreaRepository;
use App\infrastructure\repositories\guide\GuideRepository;
use App\infrastructure\repositories\guideSurvey\GuideSurveyRepository;
use App\infrastructure\repositories\question\QuestionRepository;
use App\infrastructure\repositories\survey\SurveyRepository;
use App\infrastructure\repositories\guideUser\GuideUserRepository;
use App\infrastructure\repositories\user\UserRepository;

function router(Router $router)
{
    $surveyRepository       = new SurveyRepository(new Survey);
    $guideUserRepository    = new GuideUserRepository(new GuideUser);
    $questionRepository     = new QuestionRepository(new Question);
    $userRepository         = new UserRepository(new User);
    $guideRepository        = new GuideRepository(new Guide);
    $guideSurveyRepository  = new GuideSurveyRepository(new GuideSurvey);
    $surveyService          = new SurveyService($surveyRepository, $guideUserRepository, $questionRepository, $guideSurveyRepository);
    $areaRepository         = new AreaRepository(new Area);
    $surveyUseCase          = new SurveyUseCase($surveyService, $userRepository, $areaRepository, $guideRepository);
    $pdfAdapter             = new PdfAdapter;
    $surveyController       = new SurveyController($surveyUseCase, $pdfAdapter);

    $router->get('/', function ()  use ($surveyController) {
        $surveyController->getAllSurveys();
    });

    $router->get('/show/{surveyId}', function (string $surveyId)  use ($surveyController) {
        $surveyController->showSurvey($surveyId);
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

    $router->get('/current', function () use ($surveyController) {
        $surveyController->getCurrentSurvey();
    });

    $router->get('/details/{surveId}/{userId}', function (string $id, string $userId) use ($surveyController) {
        $surveyController->getDetailsByUser($id, $userId);
    });

    $router->get('/report', function () use ($surveyController) {
        $surveyController->generateReportByUser();
    });

    $router->get('/total-users', function () use ($surveyController) {
        $surveyController->getTotalUserInSurvey();
    });

    $router->get('/{surveyId}/guide/{guideId}find-by', function (string $surveyId, string $guideId) use ($surveyController) {
        $surveyController->findSurveyDetailByUserName($surveyId, $guideId);
    });

    $router->get('/{id}/details/{guideId}', function (string $id, string $guideId) use ($surveyController) {
        $surveyController->getGudeDetailBySurvey($id, $guideId);
    });

    $router->post('/end/{id}', function (string $id) use ($surveyController) {
        $surveyController->finalizeSurvey($id);
    });
}
