<?php

namespace App\application\qualification;

use App\domain\qualification\QualificationRepository;

class QualificationUseCase
{

    public function __construct(private readonly QualificationRepository $qualificationRepository)
    {
    }

    public function findAllQualifications()
    {
        $qualifications = $this->qualificationRepository->findAll();
        return ['qualifications' => $qualifications];
    }
}
