<?php

namespace App\domain\area;

use App\domain\BaseRepository;
use Illuminate\Database\Eloquent\Collection;

interface AreaRepository extends BaseRepository {
    public function findAreasWithUsers(): Collection;
}