<?php

namespace App\infrastructure\repositories\category;

use App\domain\category\Category;
use App\domain\category\CategoryRepository as ContractsRepository;
use App\infrastructure\repositories\BaseRepository;
use Illuminate\Database\Eloquent\Collection;

class CategoryRepository extends BaseRepository implements ContractsRepository
{

    public function __construct(private readonly Category $category)
    {
        parent::__construct($category);
    }

    public function findByName(string $name): ?Category
    {
        return $this->category::where('name', $name)->first();
    }

    public function saveCategoryAndSetQualification(object $body): Category
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
            'very_high' => $body->very_high,
        ]);
        return $category;
    }

    public function findWithQualifications(): Collection
    {
        return $this->category::with('qualification')->get();
    }

}
