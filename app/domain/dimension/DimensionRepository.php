<?php

declare(strict_types=1);

namespace App\domain\dimension;

use App\domain\BaseRepository;

interface DimensionRepository extends BaseRepository
{
    public function findByName(string $name): Dimension|null;
}
