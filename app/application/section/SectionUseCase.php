<?php

namespace App\application\section;

use App\domain\section\SectionRepository;
use Exception;

class SectionUseCase
{
    public function __construct(private readonly SectionRepository $sectionRepository)
    {
    }

    public function findAllSections(): mixed
    {
        $sections = $this->sectionRepository->getAllSections();
        return ['sections' => $sections];
    }

    public function createSection(mixed $body): Exception | array
    {
        $section = [];

        $name = trim(mb_strtoupper($body->name));

        $section = $this->sectionRepository->findByName($name);
        if ($section) return new Exception('Ya existe una sección con ese nombre', 400);

        if (!$body->binary) {
            $section = $this->sectionRepository->create(['name' => $name, 'binary' => $body->binary, 'question' => null]);
            return ['section' => $section, 'message' => 'La sección se creo correctamente'];
        }

        if (!isset($body->question)) return new Exception('Para poder crear una sección es necesaria la pregunta anidada', 400);

        $section = $this->sectionRepository->create(['name' => $name, 'binary' => $body->binary, 'question' => $body->question]);
        return ['section' => $section, 'message' => 'La sección se creo correctamente'];
    }

    public function getSectionsWhereHaveQuestions()
    {
        $sections = $this->sectionRepository->findSectionsWithQuestions();
        return ['sections' => $sections];
    }

    public function getSectionsByCriteria(mixed $criteria)
    {
        $sections = $this->sectionRepository->findByCriteria((bool)$criteria);
        return ['sections' => $sections];
    }

    public function getSectionWithQuestionById(string $sectionId)
    {
        $section = $this->sectionRepository->findOne($sectionId);
        if (!$section) return new Exception('La sección no existe o no es valida', 404);
        $section = $this->sectionRepository->findSectionByIdWithQuestions($sectionId);
        return ['section' => $section];
    }

    public function getSectionsWithHisQuestions(array $sectionsId)
    {
        $countValidIDs = $this->sectionRepository->countSectionsByArrayOfSectionsId($sectionsId);
        if ($countValidIDs !== count($sectionsId)) return new Exception('Las secciones con las que intentas crear el cuestionario no son validas', 400);
        $sections = $this->sectionRepository->findMultipleSectionsWithQuestions($sectionsId);
        return ['sections' => $sections];
    }
}
