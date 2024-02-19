<?php

namespace App\application\question;

use App\application\question\QuestionServiceRepository;
use App\domain\category\CategoryRepository;
use App\domain\dimension\DimensionRepository;
use App\domain\domain\DomainRepository;
use App\domain\qualification\QualificationRepository;
use App\domain\section\Section;
use App\domain\section\SectionRepository;
use Exception;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class QuestionService implements QuestionServiceRepository
{

    public function __construct(
        private readonly CategoryRepository $categoryRepository,
        private readonly QualificationRepository $qualificationRepository,
        private readonly SectionRepository $sectionRepository,
        private readonly DomainRepository $domainRepository,
        private readonly DimensionRepository $dimensionRepository,
    ) {
    }

    public function categoryIsValid(string $id): Model | Exception
    {
        $category = $this->categoryRepository->findOne($id);
        return $category ? $category : new Exception('La categoría no es valida', 400);
    }

    public function qualificationIsValid(string $id): Model | Exception
    {
        $qualification = $this->qualificationRepository->findOne($id);
        return $qualification ? $qualification : new Exception('La calificaión no es valida', 400);
    }

    public function sectionIsValid(string $id): Model | Exception
    {
        $section = $this->sectionRepository->findOne($id);
        return $section ? $section : new Exception('La sección no es valida', 400);
    }

    public function domainIsValid(string $id): Model | Exception
    {
        $domain = $this->domainRepository->findOne($id);
        return $domain ? $domain : new Exception('El dominio no es valido', 400);
    }

    public function dimensionIsValid(string $id): Model | Exception
    {
        $dimension = $this->dimensionRepository->findOne($id);
        return $dimension ? $dimension : new Exception('La dimensión no es valida', 400);
    }

    public function getQuestionsBySections(): Collection
    {
        return $this->sectionRepository->findSectionsWithQuestions();
    }

    public function getQuestionBySection(string $page): Paginator | null
    {
        return $this->sectionRepository->findSectionWithQuestions($page);
    }

    public function getTotalSections (): int {
        return $this->sectionRepository->countTotalSections();
    }
    
    public function prepareDataToInsert(mixed $body): Exception | array
    {
        $exitQualification = $this->qualificationIsValid($body->qualification_id);
        $exitSection = $this->sectionIsValid($body->section_id);
        $exitDimension = $this->dimensionIsValid($body->dimension_id);

        if ($exitQualification instanceof Exception) return $exitQualification;
        if ($exitSection instanceof Exception) return $exitSection;
        if ($exitDimension instanceof Exception) return $exitDimension;

        return [
            'qualification' => $exitQualification,
            'section' => $exitSection,
            'dimension' => $exitDimension,
        ];
    }
}
