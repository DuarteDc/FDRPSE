<?php

namespace App\infrastructure\repositories\area;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Builder;


use App\domain\area\Area;
use App\domain\area\AreaRepository as ConfgAreaRepository;

use App\infrastructure\repositories\BaseRepository;

class AreaRepository extends BaseRepository implements ConfgAreaRepository
{
    public function __construct(private readonly Area $area)
    {
        parent::__construct($area);
    }

    public function findAreasWithUsers(): Collection
    {
        return $this->area::whereHas('users', function (Builder $query) {
            return $query->where('tipo', 1)->where('activo', true);
        })
            ->with([
                'subdirections' => function ($query) {
                    $query->where('area_nivel', '>', 1);
                },
                'subdirections.departments'
            ])
            ->where('area_nivel', 1)
            ->where('area_padre', '<=', 1)
            ->orderBy('area_padre', 'asc')
            ->get();
    }

    public function findAreaByIdAndGetChildAreas(string $areaId): Collection
    {
        return $this->area::whereHas('users', function (Builder $query) {
            return $query->where('tipo', 1)->where('activo', true);
        })
            ->with([
                'subdirections' => function ($query) {
                    $query->where('area_nivel', '>', 1);
                },
                'subdirections.departments'
            ])
            ->find($areaId);
    }
}
