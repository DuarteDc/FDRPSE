<?php

namespace App\infrastructure\controllers;

use App\kernel\controllers\Controller;
use App\application\section\SectionUseCase;
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
        $this->response($this->sectionUseCase->createSection($this->request()), 201);
    }
    
    public function getSectionsWithQuestions() 
    {
        $this->response($this->sectionUseCase->getSectionsWhereHaveQuestions());
    }
}
