<?php

declare(strict_types=1);

namespace App\infrastructure\repositories\section;

use App\domain\section\Section;
use App\domain\section\SectionRepository as ContractsRepository;

use App\infrastructure\repositories\BaseRepository;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Database\Eloquent\Collection;

final class SectionRepository extends BaseRepository implements ContractsRepository
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

    public function findSectionWithQuestions(string $guideId, string $page): Paginator|null
    {
        return $this->section::with(
            [
                'questions:id,name,section_id,qualification_id',
                'questions.qualification:id,name,always_op,almost_alwyas_op,sometimes_op,almost_never_op,never_op',
            ]
        )->where('guide_id', $guideId)
            // ->has('questions', '>', 0)
            ->simplePaginate(1, ['id', 'name', 'binary', 'question'], 'page', $page);
    }

    public function countTotalSections(string $guideId): int
    {
        return $this->section::with('questions')
            ->where('guide_id', $guideId)
            ->count();
    }

    public function findByName(string $name): ?Section
    {
        return $this->section::where('name', $name)
            ->first();
    }

    public function findByType(string $type): Collection
    {
        return $this->section::where('type', $type === $this->section::NONGRADABLE ?
            $this->section::NONGRADABLE :
            $this->section::GRADABLE)
            ->where('can_finish_guide', false)
            ->get();
    }

    public function findSectionByIdWithQuestions(string $sectionId): Section
    {
        return $this->section::with('questions.qualification')
            ->find($sectionId);
    }

    public function findMultipleSectionsWithQuestions(array $sectionsId): Collection
    {
        return $this->section::with('questions.qualification')
            ->whereIn('id', $sectionsId)->get()->sortBy(function ($model) use ($sectionsId) {
                return array_search($model->id, $sectionsId);
            })->values();
    }

    public function countSectionsByArrayOfSectionsId(array $sectionId): int
    {
        return $this->section::whereIn('id', $sectionId)
            // ->has('questions')
            ->count();
    }

    public function findAvailableSections(string $type): Collection
    {
        if ($type === $this->section::NONGRADABLE) {
            return $this->section::where('type', $this->section::NONGRADABLE)
                ->where('guide_id', null)
                ->has('questions')
                ->orWhere('can_finish_guide', true)
                ->where('guide_id', null)
                ->get();
        }

        return $this->section::where('guide_id', null)
            ->where('type', $this->section::GRADABLE)
            ->has('questions')
            ->get();
    }

    public function validateSectionsId(array $sectionsId): Collection
    {
        return $this->section::where('guide_id', null)->find($sectionsId);
    }

    public function attachGuide(string $guideId, mixed $sectionsId): ?Collection
    {
        $sections = $this->section::find($sectionsId);
        $sections->each(function (Section $section) use ($guideId) {
            $section->guide_id = $guideId;
            $section->save();
        });
        return $sections;
    }
}
