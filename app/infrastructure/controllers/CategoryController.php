<?php

declare(strict_types=1);

namespace App\infrastructure\controllers;

use App\application\category\CategoryUseCase;
use App\infrastructure\requests\category\CreateCategoryRequest;
use App\kernel\controllers\Controller;

final class CategoryController extends Controller
{
	public function __construct(private readonly CategoryUseCase $categoryUseCase) {}

	public function getAllCategories()
	{
		$this->response($this->categoryUseCase->findAllCategories());
	}

	public function createCategory()
	{
		$this->validate(CreateCategoryRequest::rules(), CreateCategoryRequest::messages());
		$this->response($this->categoryUseCase->createCategory($this->request()));
	}

	public function getCategoriesWithQualifications()
	{
		$this->response($this->categoryUseCase->findCategoriesWithQualifications());
	}

	public function getCategoryWithQualifications(string $id)
	{
		$this->response($this->categoryUseCase->findCategoryWithQualifications($id));
	}


	public function addNewQualification(string $categoryId)
	{
		$this->response($this->categoryUseCase->addQualification($categoryId, $this->request()->qualification));
	}
}
