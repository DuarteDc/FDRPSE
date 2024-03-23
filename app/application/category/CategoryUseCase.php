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

    public function createCategory(object $body): mixed
    {
        $isValidName = $this->validateName($body->name);
        if ($isValidName instanceof Exception) return $isValidName;

        $category = $this->categoryRepository->saveCategoryAndSetQualification((object)[...(array)$body, 'name' => $isValidName,]);
        return ['message' => 'La categoría se creo correctamente', 'category' => $category];
    }

    public function findCategoriesWithQualifications(): mixed
    {
        $categories = $this->categoryRepository->findWithQualifications();
        return ['categories' => $categories];
    }


    private function validateName($name): Exception | string
    {
        $name = mb_strtoupper(trim($name));
        $category = $this->categoryRepository->findByName($name);
        return $category ? new Exception('Ya existe una categoría con ese nombre', 400) : $name;
    }
}
