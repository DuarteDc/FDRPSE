<?php

namespace App\infrastructure\routes\questions;

use App\application\question\QuestionService;
use Bramus\Router\Router;

use App\domain\question\Question;
use App\application\question\QuestionUseCase;
use App\domain\category\Category;
use App\domain\domain\Domain;
use App\domain\qualification\Qualification;
use App\domain\section\Section;
use App\domain\surveyUser\SurveyUser;

use App\infrastructure\controllers\QuestionController;
use App\infrastructure\repositories\category\CategoryRepository;
use App\infrastructure\repositories\domain\DomainRepository;
use App\infrastructure\repositories\qualification\QualificationRepository;
use App\infrastructure\repositories\question\QuestionRepository;
use App\infrastructure\repositories\section\SectionRepository;
use App\infrastructure\repositories\surveyUser\SurveyUserRepository;

function router(Router $router)
{
    $categoryRepository         = new CategoryRepository(new Category());
    $qualificationRepository    = new QualificationRepository(new Qualification);
    $sectionRepository          = new SectionRepository(new Section);
    $domainRepository           = new DomainRepository(new Domain);
    $questionRepository         = new QuestionRepository(new Question);
    $questionService            = new QuestionService($categoryRepository, $qualificationRepository, $sectionRepository, $domainRepository);
    $surveyUserRespository      = new SurveyUserRepository(new SurveyUser);
    $questionUseCase            = new QuestionUseCase($questionRepository, $questionService, $surveyUserRespository);
    $questionController         = new QuestionController($questionUseCase);

    $router->get('/', function () use ($questionController) {
        $questionController->getAllQuestions();
    });

    $router->get('/sections-all', function () use ($questionController) {
        $questionController->getQuestionBySections();
    });


    $router->get('/section', function () use ($questionController) {
        $questionController->getQuestionsBySection();
    });

    $router->get('/{questionId}', function ($questionId) use ($questionController) {
        $questionController->getQuestion($questionId);
    });

    $router->post('/create', function () use ($questionController) {
        $questionController->createQuestion();
    });
};
