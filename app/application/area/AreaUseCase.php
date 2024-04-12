<?php

declare(strict_types=1);

namespace App\application\area;

use App\domain\area\AreaRepository;

final class AreaUseCase
{
    public function __construct(private readonly AreaRepository $areaRepository) {}

    public function findAllAreas()
    {
        $areas = $this->areaRepository->findAreas();
        return ['areas' => $areas];
    }

    public function getAreaDetailsById(string $areaId)
    {
        $subareas = $this->areaRepository->findAreaByIdAndGetChildAreas($areaId);
        return ['areas' => $subareas];
    }
}
