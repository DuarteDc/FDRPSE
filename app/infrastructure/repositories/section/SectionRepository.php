<?php

namespace App\infrastructure\repositories\section;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Contracts\Pagination\Paginator;

use App\domain\section\Section;
use App\domain\section\SectionRepository as ConfigSectionRepository;
use App\infrastructure\repositories\BaseRepository;

class SectionRepository extends BaseRepository implements ConfigSectionRepository
{

    public function __construct(private readonly Section $section)
    {
        parent::__construct($section);
    }

    public function getAllSections(): Collection
    {
        return $this->section::orderBy('id', 'desc')->get();
    }

    public function findSectionsWithQuestions(): Collection
    {
        return $this->section::has('questions', '>', 0)->get(['id', 'name', 'binary', 'question']);
    }

    public function findSectionWithQuestions(string $page): Paginator | null
    {
        return $this->section::with(
            [
                'questions:id,name,section_id,qualification_id',
                'questions.qualification:id,name,always_op,almost_alwyas_op,sometimes_op,almost_never_op,never_op'
            ]
        )
            ->has('questions', '>', 0)
            ->simplePaginate(1, ['id', 'name', 'binary', 'question'], 'page', $page);
    }

    public function countTotalSections(): int
    {
        return $this->section::with('questions')->has('questions', '>', 0)->count();
    }

    public function findByName(string $name): ?Section
    {
        return $this->section::where('name', $name)->first();
    }

}
