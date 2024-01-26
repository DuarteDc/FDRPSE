<?php

namespace App\infrastructure\repositories\category;

use Illuminate\Database\Eloquent\Model;
use App\domain\category\CategoryRepository as ConfigCategoryRepository;
use App\infrastructure\repositories\BaseRepository;

class CategoryRepository extends BaseRepository implements ConfigCategoryRepository
{

    public function __construct(private readonly Model $model)
    {
        parent::__construct($model);
    }

}
 