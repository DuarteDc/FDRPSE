<?php

namespace App\infrastructure\repositories\category;

use App\domain\category\Category;
use Illuminate\Database\Eloquent\Model;
use App\domain\category\CategoryRepository as ConfigCategoryRepository;
use App\infrastructure\repositories\BaseRepository;

class CategoryRepository extends BaseRepository implements ConfigCategoryRepository
{

    public function __construct(private readonly Category $category)
    {
        parent::__construct($category);
    }

    public function findByName(string $name): ?Category
    {
        return $this->category::where('name', $name)->first();
    }
}
