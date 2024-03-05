<?php

namespace App\domain\area;

use App\domain\BaseRepository;
use App\domain\area\Area;
use Illuminate\Database\Eloquent\Collection;

interface AreaRepository extends BaseRepository {
    public function findAreasWithUsers(): Collection;

    public function findAreaByIdAndGetChildAreas(string $areaId): Collection;
    
}