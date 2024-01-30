<?php

namespace App\infrastructure\repositories\dimension;

use Illuminate\Database\Eloquent\Model;

use App\infrastructure\repositories\BaseRepository;
use App\domain\dimension\DimensionRepository as ConfigDimensionRespository;

class DimensionRepository extends BaseRepository implements ConfigDimensionRespository
{
    public function __construct(private readonly Model $model)
    {
        parent::__construct($model);
    }
}
