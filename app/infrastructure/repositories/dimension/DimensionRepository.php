<?php

namespace App\infrastructure\repositories\dimension;

use App\domain\dimension\Dimension;
use App\infrastructure\repositories\BaseRepository;
use App\domain\dimension\DimensionRepository as ContractsRepository;

class DimensionRepository extends BaseRepository implements ContractsRepository
{
    public function __construct(private readonly Dimension $dimension)
    {
        parent::__construct($dimension);
    }

    public function findByName(string $name): ?Dimension
    {
        return $this->dimension::where('name', $name)->first();
    }

}
