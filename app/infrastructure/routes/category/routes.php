<?php

namespace App\infrastructure\routes\category;

use Bramus\Router\Router;

use App\domain\category\Category;
use App\application\category\CategoryUseCase;
use App\domain\survey\Survey;
use App\infrastructure\controllers\CategoryController;
use App\infrastructure\middlewares\CreateResourceMiddleware;
use App\infrastructure\middlewares\HasAdminRole;
use App\infrastructure\repositories\category\CategoryRepository;
use App\infrastructure\repositories\survey\SurveyRepository;

function router(Router $router)
{

    $checkRole = new HasAdminRole();
  

    $categoryRepository     = new CategoryRepository(new Category());
    $categoryUseCase        = new CategoryUseCase($categoryRepository);
    $categoryController     = new CategoryController($categoryUseCase);

    $router->get('/', function ()  use ($categoryController, $checkRole) {
        $checkRole->handle();
        $categoryController->getAllCategories();
    });

    $router->get('/with/qualification', function () use ($categoryController, $checkRole) {
        $checkRole->handle();
        $categoryController->getCategoriesWithQualifications();
    });

    $router->post('/create', function () use ($categoryController, $checkRole) {
        $checkRole->handle();
        $middleware = new CreateResourceMiddleware(new SurveyRepository(new Survey));
        $middleware->handle();
        $categoryController->createCategory();
    });
}
