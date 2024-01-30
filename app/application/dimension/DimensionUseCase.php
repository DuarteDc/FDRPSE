<?php

namespace App\application\dimension;

use App\domain\dimension\DimensionRepository;

class DimensionUseCase
{

    public function __construct(private readonly DimensionRepository $dimensionRespository)
    {
    }

    public function findAllDimensions()
    {
        $dimensions = $this->dimensionRespository->findAll();
        return ['dimensions' => $dimensions];
    }

    public function createDimension(mixed $body) {
        $dimension = $this->dimensionRespository->create($body);
        return ['message' => 'La dimension se creo correctamente', 'dimension' => $dimension];
    }

}
