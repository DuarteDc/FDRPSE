<?php

namespace App\infrastructure\repositories\area;

use App\domain\area\Area;
use App\domain\area\AreaRepository as ContractsRepository;

use App\infrastructure\repositories\BaseRepository;
use Illuminate\Database\Eloquent\Builder;

use Illuminate\Database\Eloquent\Collection;

final class AreaRepository extends BaseRepository implements ContractsRepository
{
	public function __construct(private readonly Area $area)
	{
		parent::__construct($area);
	}

	public function findAreas(): Collection
	{
		return $this->area::whereHas('users', function (Builder $query) {
			return $query->where('tipo', 1)->where('activo', true);
		})
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
			->where('area_padre', $areaId)
			->where('area_padre', '<>', 1)
			->get();
	}

	public function countAreasByAreasId(array $areasId): int
	{
		return $this->area->whereIn('id', $areasId)->pluck('id')->count();
	}
}
