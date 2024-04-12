<?php

declare(strict_types=1);

namespace App\application\section;

use App\domain\section\SectionRepository;
use Exception;

final class SectionUseCase
{
    public function __construct(private readonly SectionRepository $sectionRepository) {}

    public function searchSections(string $type, string $name): mixed
    {
        $sections = $this->sectionRepository->getSectionsByType($type, mb_strtoupper($name));
        return ['sections' => $sections];
    }

    public function getSectionDetail(string $id)
    {
        $section = $this->sectionRepository->findOne($id);
        return ['section' => $section];
    }

    public function getSectionWithoutGuide(string $type)
    {
        return ['sections' => $this->sectionRepository->findAvailableSections($type)];
    }

    public function createSection(mixed $body): array|Exception
    {
        $section = [];

        $name = trim(mb_strtoupper($body->name));

        $section = $this->sectionRepository->findByName($name);
        if ($section) {
            return new Exception('Ya existe una sección con ese nombre', 400);
        }

        if (!$body->binary) {
            $section = $this->sectionRepository->create([
                'name' => $name, 'binary' => $body->binary, 'question' => null, 'can_finish_guide' => $body->can_finish_guide, 'type' => $body->type,
            ]);
            return ['section' => $section, 'message' => 'La sección se creo correctamente'];
        }

        if (!isset($body->question)) {
            return new Exception('Para poder crear una sección es necesaria la pregunta anidada', 400);
        }

        $section = $this->sectionRepository->create(
            ['name' => $name, 'binary' => $body->binary, 'question' => $body->question,  'can_finish_guide' => $body->can_finish_guide, 'type' => $body->type]
        );
        return ['section' => $section, 'message' => 'La sección se creo correctamente'];
    }

    public function getSectionsWhereHaveQuestions()
    {
        $sections = $this->sectionRepository->findSectionsWithQuestions();
        return ['sections' => $sections];
    }

    public function getSectionsByType(string $type)
    {
        $sections = $this->sectionRepository->findByType($type);
        return ['sections' => $sections];
    }

    public function getSectionWithQuestionById(string $sectionId)
    {
        $section = $this->sectionRepository->findOne($sectionId);
        if (!$section) {
            return new Exception('La sección no existe o no es valida', 404);
        }
        $section = $this->sectionRepository->findSectionByIdWithQuestions($sectionId);
        return ['section' => $section];
    }

    public function getSectionsWithHisQuestions(array $sectionsId)
    {
        $countValidIDs = $this->sectionRepository->countSectionsByArrayOfSectionsId($sectionsId);
        if ($countValidIDs !== count($sectionsId)) {
            return new Exception('Las secciones con las que intentas crear el cuestionario no son validas', 400);
        }
        $sections = $this->sectionRepository->findMultipleSectionsWithQuestions($sectionsId);
        return ['sections' => $sections];
    }
}
