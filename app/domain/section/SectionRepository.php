<?php

namespace App\domain\section;

use Illuminate\Database\Eloquent\Collection;

use App\domain\BaseRepository;
use Illuminate\Contracts\Pagination\Paginator;

interface SectionRepository extends BaseRepository
{
    public function findSectionsWithQuestions(): Collection;
    public function findSectionWithQuestions(string $page): Paginator | null;
    public function countTotalSections(): int;
}
