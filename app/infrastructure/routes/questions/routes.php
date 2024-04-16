<?php

namespace App\infrastructure\routes\questions;

use App\application\question\QuestionService;
use App\application\question\QuestionUseCase;

use App\domain\category\Category;
use App\domain\dimension\Dimension;
use App\domain\domain\Domain;
use App\domain\qualification\Qualification;
use App\domain\qualificationQuestion\QualificationQuestion;
use App\domain\question\Question;
use App\domain\section\Section;
use App\domain\survey\Survey;
use App\infrastructure\controllers\QuestionController;

use App\infrastructure\middlewares\CreateResourceMiddleware;
use App\infrastructure\middlewares\HasAdminRoleMiddleware;
use App\infrastructure\repositories\category\CategoryRepository;
use App\infrastructure\repositories\dimension\DimensionRepository;
use App\infrastructure\repositories\domain\DomainRepository;
use App\infrastructure\repositories\qualification\QualificationRepository;

use App\infrastructure\repositories\qualificationQuestion\QualificationQuestionRepository;
use App\infrastructure\repositories\question\QuestionRepository;
use App\infrastructure\repositories\section\SectionRepository;
use App\infrastructure\repositories\survey\SurveyRepository;
use Bramus\Router\Router;

function router(Router $router)
{
	$categoryRepository      = new CategoryRepository(new Category());
	$qualificationRepository = new QualificationRepository(new Qualification());
	$sectionRepository       = new SectionRepository(new Section());
	$domainRepository        = new DomainRepository(new Domain());
	$questionRepository      = new QuestionRepository(new Question());
	$dimensionRepository     = new DimensionRepository(new Dimension());
	$questionService         = new QuestionService(
		$categoryRepository,
		$qualificationRepository,
		$sectionRepository,
		$domainRepository,
		$dimensionRepository
	);
	$qualificationQuestionRepository = new QualificationQuestionRepository(new QualificationQuestion());
	$questionUseCase                 = new QuestionUseCase(
		$questionRepository,
		$questionService,
		$qualificationQuestionRepository
	);
	$questionController              = new QuestionController($questionUseCase);
	$hasAdminRole					 = new HasAdminRoleMiddleware();

	$middleware = new CreateResourceMiddleware(new SurveyRepository(new Survey));

	$router->get('/', function () use ($questionController) {
		$questionController->getAllQuestions();
	});

	$router->get('/sections-all', function () use ($questionController) {
		$questionController->getQuestionBySections();
	});


	$router->get('/section/{guideId}', function (string $guideId) use ($questionController) {
		$questionController->getQuestionsBySection($guideId);
	});

	$router->get('/{questionId}', function ($questionId) use ($questionController) {
		$questionController->getQuestion($questionId);
	});

	$router->post('/create', function () use ($questionController, $middleware, $hasAdminRole) {
		$hasAdminRole->handle();
		$middleware->handle();
		$questionController->createQuestion();
	});

	$router->patch('/update/{questionId}', function (string $questionId) use ($questionController, $middleware, $hasAdminRole) {
		$hasAdminRole->handle();
		$middleware->handle();
		$questionController->updateQuestion($questionId);
	});
};
