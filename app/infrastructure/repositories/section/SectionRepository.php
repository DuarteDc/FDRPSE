<?php

namespace App\infrastructure\repositories\section;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Contracts\Pagination\Paginator;

use App\domain\section\Section;
use App\domain\section\SectionRepository as ContractsRepository;
use App\infrastructure\repositories\BaseRepository;

class SectionRepository extends BaseRepository implements ContractsRepository
{

    public function __construct(private readonly Section $section)
    {
        parent::__construct($section);
    }

    public function getSectionsByType(string $type, string $name): Collection
    {
        return $this->section::where(
            'type',
            $type === $this->section::NONGRADABLE ?
                $this->section::NONGRADABLE :
                $this->section::GRADABLE
        )
            ->where('name', 'like', "%{$name}%")
            ->get();
    }

    public function findOne(string $id): ?Section
    {
        return $this->section::with([
            'questions',
            'questions.section',
            'questions.qualification',
            'questions.category',
            'questions.dimension',
            'questions.domain',
        ])
            ->find($id);
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

    public function findByCriteria(bool $criteria): Collection
    {
        return $this->section::whereHas('questions', function ($query) use ($criteria) {
            $criteria ? $query->where('type', $this->section::GRADABLE)
                :   $query->where('type', $this->section::NONGRADABLE);
        })->get();
    }

    public function findSectionByIdWithQuestions(string $sectionId): Section
    {
        return $this->section::with('questions.qualification')->find($sectionId);
    }

    public function findMultipleSectionsWithQuestions(array $sectionsId): Collection
    {
        return $this->section::with('questions.qualification')
            ->has('questions')
            ->find($sectionsId);
    }

    public function countSectionsByArrayOfSectionsId(array $sectionId): int
    {
        return $this->section::whereIn('id', $sectionId)
            ->has('questions')
            ->count();
    }
}
