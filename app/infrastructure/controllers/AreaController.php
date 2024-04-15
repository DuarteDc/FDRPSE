<?php

declare(strict_types=1);

namespace App\infrastructure\controllers;

use App\application\area\AreaUseCase;
use App\kernel\controllers\Controller;

final class AreaController extends Controller
{
	public function __construct(private readonly AreaUseCase $areaUseCase) {}

	public function getAreas()
	{
		$this->response($this->areaUseCase->findAllAreas());
	}

	public function getAreaDetail(string $areaId)
	{
		$this->response(($this->areaUseCase->getAreaDetailsById($areaId)));
	}
}
