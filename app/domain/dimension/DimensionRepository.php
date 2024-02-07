<?php


namespace App\domain\dimension;

use App\domain\BaseRepository;
use App\domain\dimension\Dimension;

interface DimensionRepository extends BaseRepository
{
    public function findByName(string $name): Dimension | null;
}
