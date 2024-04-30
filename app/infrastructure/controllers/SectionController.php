<?php

namespace App\infrastructure\controllers;

use App\application\section\SectionUseCase;
use App\infrastructure\requests\section\CreateSectionRequest;
use App\kernel\controllers\Controller;

final class SectionController extends Controller
{
	public function __construct(private readonly SectionUseCase $sectionUseCase) {}

	public function getAllSections()
	{
		$type = (string) $this->get('type');
		$name = (string) $this->get('name');
		$guide = (string) $this->get('guide');
		$this->response($this->sectionUseCase->searchSections($type, $name, $guide));
	}

	public function getOneSection(string $id)
	{
		$this->response($this->sectionUseCase->getSectionDetail($id));
	}

	public function getAvailableSections()
	{
		$type = (string) $this->get('type');
		$this->response($this->sectionUseCase->getSectionWithoutGuide($type));
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

	public function getSectionsByType()
	{
		$type = (string) $this->get('type');
		$this->response($this->sectionUseCase->getSectionsByType($type));
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

	public function deteleQuestion(string $sectionId, string $questionId)  
	{
		$this->response($this->sectionUseCase->deleteQuestionInsideSection($sectionId, $questionId));
	}

}
