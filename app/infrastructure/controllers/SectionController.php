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

    public function createSection()
    {
        $this->validate(CreateSectionRequest::rules(), CreateSectionRequest::messages());
        $this->response($this->sectionUseCase->createSection($this->request()), 201);
    }

    public function getSectionsWithQuestions()
    {
        $this->response($this->sectionUseCase->getSectionsWhereHaveQuestions());
    }

    public function getSectionsBy()
    {
        $gradable = (string) $this->get('type');
        $gradable = json_decode(trim($gradable));
        $this->response($this->sectionUseCase->getSectionsByCriteria($gradable));
    }

    public function getSectionWithQuestions(string $sectionId)
    {
        $this->response($this->sectionUseCase->getSectionWithQuestionById($sectionId));
    }

    public function getSectionsWithHisQuestions()
    {
        $sectionsId = (array) $this->request()->sections;
        $this->response($this->sectionUseCase->getSectionsWithHisQuestions($sectionsId));
    }
}
