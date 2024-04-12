<?php

declare(strict_types=1);

namespace App\domain\section;

use App\domain\BaseRepository;

use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Database\Eloquent\Collection;

interface SectionRepository extends BaseRepository
{
    public function getSectionsByType(string $type, string $name): Collection;
    public function getAllSections(): Collection;
    public function findOne(string $id): ?Section;
    public function findSectionsWithQuestions(): Collection;
    public function findSectionWithQuestions(string $guideId, string $page): Paginator|null;
    public function countTotalSections(string $guideId): int;
    public function findByName(string $name): ?Section;
    public function findByType(string $criteria): Collection;
    public function findSectionByIdWithQuestions(string $sectionId): Section;
    public function findMultipleSectionsWithQuestions(array $sectionsId): Collection;
    public function countSectionsByArrayOfSectionsId(array $sectionId): int;
    public function findAvailableSections(string $type): ?Collection;
    public function attachGuide(string $guideId, mixed $sectionsId): ?Collection;
    public function validateSectionsId(array $sectionsId): Collection;
}
