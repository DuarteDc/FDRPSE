<?php

namespace App\infrastructure\routes\category;

use Bramus\Router\Router;

use App\domain\category\Category;
use App\application\category\CategoryUseCase;
use App\infrastructure\controllers\CategoryController;
use App\infrastructure\repositories\category\CategoryRepository;

function router(Router $router)
{

    $categoryRepository     = new CategoryRepository(new Category());
    $categoryUseCase        = new CategoryUseCase($categoryRepository);
    $categoryController     = new CategoryController($categoryUseCase);

    $router->get('/', function ()  use ($categoryController) {
        $categoryController->getAllCategories();
    });

    $router->post('/create', function () use ($categoryController) {
        $categoryController->createCategory();
    });
    
}
