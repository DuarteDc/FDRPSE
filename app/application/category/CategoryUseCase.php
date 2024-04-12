<?php

declare(strict_types=1);

namespace App\application\category;

use App\domain\category\CategoryRepository;
use Exception;

final class CategoryUseCase
{
    public function __construct(private readonly CategoryRepository $categoryRepository) {}

    public function findAllCategories(): mixed
    {
        $categories = $this->categoryRepository->findAll();
        return ['categories' => $categories];
    }

    public function createCategory(object $body): mixed
    {
        $isValidName = $this->validateName($body->name);
        if ($isValidName instanceof Exception) {
            return $isValidName;
        }

        $category = $this->categoryRepository->saveCategoryAndSetQualification(
            (object) [...(array) $body, 'name' => $isValidName, ]
        );
        return ['message' => 'La categoría se creo correctamente', 'category' => $category];
    }

    public function findCategoriesWithQualifications(): mixed
    {
        $categories = $this->categoryRepository->findWithQualifications();
        return ['categories' => $categories];
    }

    public function findCategoryWithQualifications(string $categoryId)
    {
        $category = $this->categoryRepository->findOne($categoryId);
        if (!$category) {
            return new Exception('La categoría no existe o no es valida', 404);
        }
        $category = $this->categoryRepository->findOneWithQualifications($categoryId);
        return ['category' => $category];
    }

    public function addQualification(string $categoryId, mixed $body)
    {
        $category = $this->categoryRepository->findOne($categoryId);
        if (!$category) {
            return new Exception('La categoría no existe o no es valida', 404);
        }
        $category = $this->categoryRepository->addNewQualification($category, $body);
        return ['category' => $category, 'message' => 'La calificación se agrego correctamente'];
    }

    private function validateName($name): Exception|string
    {
        $name = mb_strtoupper(trim($name));
        $category = $this->categoryRepository->findByName($name);
        return $category ? new Exception('Ya existe una categoría con ese nombre', 400) : $name;
    }
}
