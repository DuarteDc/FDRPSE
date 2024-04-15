<?php

declare(strict_types=1);

namespace App\application\qualification;

use App\domain\qualification\QualificationRepository;

final class QualificationUseCase
{
	public function __construct(private readonly QualificationRepository $qualificationRepository) {}

	public function findAllQualifications(): mixed
	{
		$qualifications = $this->qualificationRepository->findAll();
		return ['qualifications' => $qualifications];
	}
}
