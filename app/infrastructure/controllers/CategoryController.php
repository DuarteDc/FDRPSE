<?php

namespace App\infrastructure\controllers;

use App\application\category\CategoryUseCase;
use App\Http\Controllers\Controller;
use App\infrastructure\requests\category\CreateCategoryRequest;
use App\Models\Category;

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
        $this->response($this->categoryUseCase->createCategory($this->request()));
    }
}
