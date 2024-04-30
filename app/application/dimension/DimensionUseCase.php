<?php


namespace App\application\dimension;

use App\domain\dimension\DimensionRepository;
use Exception;

final class DimensionUseCase
{
	public function __construct(private readonly DimensionRepository $dimensionRespository) {}

	public function findAllDimensions()
	{
		$dimensions = $this->dimensionRespository->findAll();
		return ['dimensions' => $dimensions];
	}

	public function createDimension(mixed $body)
	{
		$isValidName = $this->validateName($body->name);
		if ($isValidName instanceof Exception) {
			return $isValidName;
		}

		$dimension = $this->dimensionRespository->create(['name' => $isValidName]);
		return ['message' => 'La dimension se creo correctamente', 'dimension' => $dimension];
	}

	public function updateDimension(string $dimensionId, array $body)
	{
		$dimension = $this->dimensionRespository->findOne($dimensionId);
		if (!$dimension) {
			return new Exception('La dimensión que intentas actualizar no existe', 404);
		}

		$existDimension = $this->dimensionRespository->canUpdateName($dimensionId, $body['name']);

		if ($existDimension) {
			return new Exception('El nombre que seas actualizar ya existe', 400);
		}

		return [
			'dimension' => $this->dimensionRespository->update(
				$dimension,
				['name' => mb_strtoupper(trim($body['name']))]
			), 'message' => 'La dimensión se actualizó correctamente',
		];
	}

	public function deleteDimension(string $dimensionId)
	{
		$dimension = $this->dimensionRespository->findOne($dimensionId);
		if (!$dimension) {
			return new Exception('La dimension no existe o no es valida', 400);
		}
		$this->dimensionRespository->delete($dimension);
		return ['message' => 'La dimensión se eliminó correctamente'];
	}


	private function validateName(string $name): Exception|string
	{
		$name      = mb_strtoupper(trim($name));
		$dimension = $this->dimensionRespository->findByName($name);
		return $dimension ? new Exception('Ya existe una dimensión con ese nombre', 400) : $name;
	}
}
