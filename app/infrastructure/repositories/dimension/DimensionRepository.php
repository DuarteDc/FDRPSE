<?php

declare(strict_types=1);

namespace App\infrastructure\repositories\dimension;

use App\domain\dimension\Dimension;
use App\domain\dimension\DimensionRepository as ContractsRepository;
use App\infrastructure\repositories\BaseRepository;

final class DimensionRepository extends BaseRepository implements ContractsRepository
{
	public function __construct(private readonly Dimension $dimension)
	{
		parent::__construct($dimension);
	}

	public function findByName(string $name): ?Dimension
	{
		return $this->dimension::where('name', $name)->first();
	}
}
