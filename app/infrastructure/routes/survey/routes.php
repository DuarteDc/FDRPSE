<?php

namespace App\infrastructure\routes\survey;

use App\application\survey\SurveyService;
use Bramus\Router\Router;

use App\domain\survey\Survey;
use App\application\survey\SurveyUseCase;
use App\domain\qualification\Qualification;
use App\domain\question\Question;
use App\domain\surveyUser\SurveyUser;
use App\infrastructure\controllers\SurveyController;
use App\infrastructure\repositories\question\QuestionRepository;
use App\infrastructure\repositories\survey\SurveyRepository;
use App\infrastructure\repositories\surveyUser\SurveyUserRepository;

function router(Router $router)
{
    $surveyRepository       = new SurveyRepository(new Survey);
    $surveyUserRepository   = new SurveyUserRepository(new SurveyUser);
    $questionRepository     = new QuestionRepository(new Question);
    $surveyService          = new SurveyService($surveyRepository, $surveyUserRepository, $questionRepository);
    $surveyUseCase          = new SurveyUseCase($surveyService);
    $surveyController       = new SurveyController($surveyUseCase);

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

    $router->get('/{id}', function (string $id) use($surveyController) {
        $surveyController->getSurveyById($id);
    });
}

