<?php

namespace App\infrastructure\controllers;

use App\application\section\SectionUseCase;
use App\Http\Controllers\Controller;
use App\infrastructure\requests\section\CreateSectionRequest;

class SectionController extends Controller
{

    public function __construct(private readonly SectionUseCase $sectionUseCase)
    {
    }

    public function getAllSections()
    {
        $this->response($this->sectionUseCase->findAllSections());
    }

    public function createSection() {
        $this->validate(CreateSectionRequest::rules(), CreateSectionRequest::messages());
        $this->response($this->sectionUseCase->createSection($this->request()));
    }

}
