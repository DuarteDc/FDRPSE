<?php

namespace App\application\category;
use App\domain\category\CategoryRepository;

class CategoryUseCase
{

    public function __construct(private readonly CategoryRepository $categoryRepository)
    {
    }

    public function findAllCategories(): mixed
    {
        $categories = $this->categoryRepository->findAll();
        return ['categories' => $categories];
    }

    public function createCategory(mixed $body): mixed
    {
        $category = $this->categoryRepository->create($body);
        return ['category' => $category];
    }
}
