<?php

namespace App\infrastructure\repositories\area;

use Illuminate\Database\Eloquent\Collection;
use App\domain\area\Area;
use App\infrastructure\repositories\BaseRepository;
use App\domain\area\AreaRepository as ConfgAreaRepository;
use Illuminate\Database\Eloquent\Builder;

class AreaRepository extends BaseRepository implements ConfgAreaRepository
{      
    public function __construct(private readonly Area $area)
    {
        parent::__construct($area);
    }

    public function findAreasWithUsers(): Collection
    {
        return $this->area::whereHas('users', function(Builder $query) {
            return $query->where('tipo', 1);
        })->get();
    }

    

}
