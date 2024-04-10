<?php

namespace App\domain\category;

use App\domain\BaseRepository;
use App\domain\category\Category;
use Illuminate\Database\Eloquent\Collection;

interface CategoryRepository extends BaseRepository {
    public function findByName(string $name): Category | null;

    public function saveCategoryAndSetQualification(object $body): Category;

    public function setCategoryQualification(Category $category, object $body): Category;

    public function findWithQualifications(): Collection;

    public function findOneWithQualifications(string $categoryId): ?Category;

    public function findOneWithQualification(string $id, string $qualificationId): Category | null;

    public function addNewQualification(Category $category, mixed $qualification): Category;
}