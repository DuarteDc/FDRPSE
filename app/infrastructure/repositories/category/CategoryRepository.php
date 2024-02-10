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

    public function saveCategoryAndSetQualification(mixed $body): Category
    {
        $category = new $this->category(['name' => $body->name]);
        $category->save();
        return $this->setCategoryQualification($category, $body);
    }

    public function setCategoryQualification(Category $category, object $body): Category
    {
        $category->qualifications()->create([
            'despicable' => $body->despicable, 
            'low'        => $body->low,
            'middle'     => $body->middle,
            'high'       => $body->high,
            'very_hight' => $body->very_hight,
        ]);
        return $category;
    }

}
