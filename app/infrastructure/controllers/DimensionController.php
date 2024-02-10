<?php


namespace App\infrastructure\controllers;

use App\kernel\controllers\Controller;
use App\application\dimension\DimensionUseCase;
use App\infrastructure\requests\dimension\CreateDimensionRequest;

class DimensionController extends Controller
{


    public function __construct(private readonly DimensionUseCase $dimensionUseCase)
    {
    }

    public function getAllDimensions()
    {
        $this->response($this->dimensionUseCase->findAllDimensions());
    }

    public function createDimension() {
        $this->validate(CreateDimensionRequest::rules(), CreateDimensionRequest::messages());
        $this->response($this->dimensionUseCase->createDimension($this->request()), 201);
    }

}
