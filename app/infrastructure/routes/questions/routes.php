<?php

namespace App\infrastructure\routes\questions;

use App\application\question\QuestionService;
use Bramus\Router\Router;

use App\domain\question\Question;
use App\application\question\QuestionUseCase;
use App\domain\qualification\Qualification;
use App\domain\section\Section;
use App\infrastructure\controllers\QuestionController;
use App\infrastructure\repositories\category\CategoryRepository;
use App\infrastructure\repositories\domain\DomainRepository;
use App\infrastructure\repositories\qualification\QualificationRepository;
use App\infrastructure\repositories\question\QuestionRepository;
use App\infrastructure\repositories\section\SectionRepository;
use App\Models\Category;
use App\Models\Domain;

function router(Router $router)
{
    $categoryRepository         = new CategoryRepository(new Category);
    $qualificationRepository    = new QualificationRepository(new Qualification);
    $sectionRepository          = new SectionRepository(new Section);
    $domainRepository           = new DomainRepository(new Domain);
    $questionService            = new QuestionService($categoryRepository, $qualificationRepository, $sectionRepository, $domainRepository);
    $questionRepository         = new QuestionRepository(new Question);
    $questionUseCase            = new QuestionUseCase($questionRepository, $questionService);
    $questionController         = new QuestionController($questionUseCase);

    $router->get('/', function () use ($questionController) {
        $questionController->index();
    });

    $router->post('/create', function () use ($questionController) {
        $questionController->createQuestion();
    });

    $router->get('/{id}', function (string $id) use ($questionController) {
        $questionController->getQuestion($id);
    });

};
