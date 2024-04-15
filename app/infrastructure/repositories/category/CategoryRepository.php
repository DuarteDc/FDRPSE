<?php

declare(strict_types=1);

namespace App\infrastructure\repositories\category;

use App\domain\category\Category;
use App\domain\category\CategoryRepository as ContractsRepository;
use App\infrastructure\repositories\BaseRepository;
use Illuminate\Database\Eloquent\Collection;

final class CategoryRepository extends BaseRepository implements ContractsRepository
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
		$category->qualifications()->createManyQuietly($body->qualifications);
		return $category;
	}

	public function findWithQualifications(): Collection
	{
		return $this->category::with('qualification')->get();
	}

	public function findOneWithQualifications(string $categoryId): ?Category
	{
		return $this->category::with('qualifications')->find($categoryId);
	}

	public function findOneWithQualification(string $id, string $qualificationId): Category|null
	{
		return $this->category::where('id', $id)
			->with('qualification', function ($query) use ($qualificationId) {
				$query->where('id', $qualificationId);
			})->first();
	}

	public function addNewQualification(Category $category, mixed $qualification): Category
	{
		$category->qualification()->create($qualification);
		return $this->findOneWithQualifications($category->id);
	}
}
