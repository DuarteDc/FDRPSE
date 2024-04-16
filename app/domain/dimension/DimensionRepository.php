<?php

namespace App\domain\dimension;

use App\domain\BaseRepository;

interface DimensionRepository extends BaseRepository
{
	public function findByName(string $name): Dimension|null;
	public function update(Dimension $dimension, array $body): Dimension;
	public function delete(Dimension $dimensionId): void;
	public function canUpdateName(string $dimensionId, string $name): ?Dimension;
}
