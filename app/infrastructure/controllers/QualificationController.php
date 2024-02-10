<?php

namespace App\infrastructure\controllers;

use App\kernel\controllers\Controller;
use App\application\qualification\qualificationUseCase;

class QualificationController extends Controller
{

    public function __construct(private readonly qualificationUseCase $qualificationUseCase)
    {
    }

    public function getAllQualifications() {
        $this->response($this->qualificationUseCase->findAllQualifications());
    }


}
