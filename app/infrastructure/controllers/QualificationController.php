<?php

namespace App\infrastructure\controllers;

use App\application\qualification\qualificationUseCase;
use App\Http\Controllers\Controller;

class QualificationController extends Controller
{

    public function __construct(private readonly qualificationUseCase $qualificationUseCase)
    {
    }

    public function getAllQualifications() {
        $this->response($this->qualificationUseCase->findAllQualifications());
    }


}
