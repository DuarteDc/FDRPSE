<?php

namespace App\domain\section;

use Illuminate\Database\Eloquent\Collection;

use App\domain\BaseRepository;
use App\domain\section\Section;
use Illuminate\Contracts\Pagination\Paginator;

interface SectionRepository extends BaseRepository
{
    public function getAllSections(): Collection;
    public function findSectionsWithQuestions(): Collection;
    public function findSectionWithQuestions(string $page): Paginator | null;
    public function countTotalSections(): int;
    public function findByName(string $name): ?Section;
    public function findByCriteria(string $criteria): Collection;
    public function findSectionByIdWithQuestions(string $sectionId): Section;
    public function findMultipleSectionsWithQuestions(array $sectionsId): Collection;
    public function countSectionsByArrayOfSectionsId(array $sectionId): int;

}
