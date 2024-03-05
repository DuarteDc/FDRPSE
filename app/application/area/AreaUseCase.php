<?php

namespace App\application\area;

use App\domain\area\AreaRepository;

class AreaUseCase
{
    public function __construct(private readonly AreaRepository $areaRepository)
    {
    }

    public function findAllAreas()
    {
        $areas = $this->areaRepository->findAreasWithUsers();
        return ['areas' => $areas];
    }

    public function getAreaDetailsById(string $areaId)
    {   
        return $this->areaRepository->findAreaByIdAndGetChildAreas($areaId);

    }
}
