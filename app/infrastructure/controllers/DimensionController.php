<?php

declare(strict_types=1);

namespace App\infrastructure\controllers;

use App\application\dimension\DimensionUseCase;
use App\infrastructure\requests\dimension\CreateDimensionRequest;
use App\infrastructure\requests\dimension\UpdateDimensionRequest;
use App\kernel\controllers\Controller;

final class DimensionController extends Controller
{
	public function __construct(private readonly DimensionUseCase $dimensionUseCase) {}

	public function getAllDimensions()
	{
		$this->response($this->dimensionUseCase->findAllDimensions());
	}

	public function createDimension()
	{
		$this->validate(CreateDimensionRequest::rules(), CreateDimensionRequest::messages());
		$this->response($this->dimensionUseCase->createDimension($this->request()), 201);
	}

	public function updateDimension(string $dimensionId)
	{
		$this->validate(UpdateDimensionRequest::rules(), UpdateDimensionRequest::messages());
		$this->response($this->dimensionUseCase->updateDimension($dimensionId, (array) $this->request()));
	}

	public function deleteDimension(string $dimensionId)
	{
		$this->response($this->dimensionUseCase->deleteDimension($dimensionId));
	}
}
