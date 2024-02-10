<?php

namespace App\infrastructure\controllers;

use App\kernel\controllers\Controller;
use App\application\category\CategoryUseCase;
use App\infrastructure\requests\category\CreateCategoryRequest;

class CategoryController extends Controller
{

    public function __construct(private readonly CategoryUseCase $categoryUseCase)
    {
    }

    public function getAllCategories()
    {
        $this->response($this->categoryUseCase->findAllCategories());
    }

    public function createCategory()
    {
        $this->validate(CreateCategoryRequest::rules(), CreateCategoryRequest::messages());
        // return $this->response($this->request());
        $this->response($this->categoryUseCase->createCategory($this->request()));
    }
}
