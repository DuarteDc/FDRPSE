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
        $isValidName = $this->validateName($body->name);
        if ($isValidName instanceof Exception) return $isValidName;

        $dimension = $this->dimensionRespository->create(['name' => $isValidName]);
        return ['message' => 'La dimension se creo correctamente', 'dimension' => $dimension];
    }

    private function validateName(string $name): Exception | string
    {
        $name = mb_strtoupper(trim($name));
        $dimension = $this->dimensionRespository->findByName($name);
        return $dimension ? new Exception('Ya existe una dimensión con ese nombre', 400) : $name;
    }
}
