<?php

namespace App\application\dimension;

use App\domain\dimension\DimensionRepository;
use Exception;

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
    
    public function createDimension(mixed $body)
    {
        $name = mb_strtoupper(trim($body->name));
        $dimension = $this->dimensionRespository->findByName($name);

        if($dimension) return new Exception('Ya existe una dimensión con ese nombre', 400);

        $dimension = $this->dimensionRespository->create($body);
        return ['message' => 'La dimension se creo correctamente', 'dimension' => $dimension];
    }
}
