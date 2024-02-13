<?php

namespace App\domain\category;

use App\domain\BaseRepository;
use App\domain\category\Category;

interface CategoryRepository extends BaseRepository {
    public function findByName(string $name): Category | null;

    public function saveCategoryAndSetQualification(object $body): Category;

    public function setCategoryQualification(Category $category, object $body): Category;
}