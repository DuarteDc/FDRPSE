<?php

namespace App\application\category;

use App\domain\category\CategoryRepository;
use Exception;

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
        $name = mb_strtoupper(trim($body->name));
        $category = $this->categoryRepository->findByName($name);
        if($category) return new Exception('Ya existe una categoría con ese nombre', 400);
        $category = $this->categoryRepository->create(['name' => $name]);
        return ['message' => 'La categoría se creo correctamente'];
    }
}
