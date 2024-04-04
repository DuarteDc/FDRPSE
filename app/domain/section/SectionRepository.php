<?php

namespace App\domain\section;

use Illuminate\Database\Eloquent\Collection;

use App\domain\BaseRepository;
use App\domain\section\Section;
use Illuminate\Contracts\Pagination\Paginator;

interface SectionRepository extends BaseRepository
{
    public function getSectionsByType(string $type, string $name): Collection;
    public function getAllSections(): Collection;
    public function findOne(string $id): ?Section;
    public function findSectionsWithQuestions(): Collection;
    public function findSectionWithQuestions(string $guideId, string $page): Paginator | null;
    public function countTotalSections(string $guideId): int;
    public function findByName(string $name): ?Section;
    public function findByType(string $criteria): Collection;
    public function findSectionByIdWithQuestions(string $sectionId): Section;
    public function findMultipleSectionsWithQuestions(array $sectionsId): Collection;
    public function countSectionsByArrayOfSectionsId(array $sectionId): int;

}
