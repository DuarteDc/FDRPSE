<?php

namespace App\infrastructure\repositories\guide;

use App\domain\guide\Guide;
use App\domain\guide\GuideRepository as ContractsRepository;
use App\domain\guideSurvey\GuideStatus;
use App\infrastructure\repositories\BaseRepository;
use Illuminate\Database\Eloquent\Collection;

class GuideRepository extends BaseRepository implements ContractsRepository
{

    public function __construct(private readonly Guide $guide)
    {
        parent::__construct($guide);
    }

    public function findByName(string $name): ?Guide
    {
        return $this->guide->where('name', $name)->first();
    }

    public function disableGuide(string $guideId): Guide
    {
        return $this->guide::find($guideId)->update(['status' => false]);
    }

    public function createAndSetQualification(object $body): Guide
    {
        $guide = new $this->guide(['name' => $body->name]);
        $guide->save();
        return $this->setGuideQualification($guide, $body);
    }

    public function setGuideQualification(Guide $guide, object $body): Guide
    {
        $guide->qualification()->create([
            'despicable' => $body->despicable,
            'low'        => $body->low,
            'middle'     => $body->middle,
            'high'       => $body->high,
            'very_high'  => $body->very_high,
        ]);
        return $guide;
    }

    public function findGuideByTypeAndName(string $type, string $name): Collection
    {
        return $this->guide->where('status', ($type !== $this->guide::DISABLE))
            ->where('name', 'like', "%{$name}%")
            ->get();
    }

    public function countGuidesById(array $guidesId): array
    {
        return $this->guide::with('qualification')->find($guidesId)->toArray();
    }

    public function deleteGuide(string $guideId)
    {
        return $this->guide::where('id', $guideId)->delete();
    }

    public function findGuideWithQualification(string $guideId): ?Guide
    {
        return $this->guide::with(['survey:id', 'survey:pivot.qualification'])->find($guideId);
    }

    public function findGuideBySurvey(string $surveyId, string $guideId): ?Guide
    {
        return $this->guide
            ->whereHas('surveys', function ($query) use ($surveyId) {
                $query->where('surveys.id', $surveyId);
            })->with(['surveys' => function($query) use($surveyId) {
                    $query->where('surveys.id', $surveyId)->first();
            }, 'surveys:id', 'surveys:pivot'])
            ->find($guideId);
    }

    public function changeGuideSurveyStatus(Guide $guide, string $surveyId, GuideStatus $status): Guide
    {
        $guide->surveys()->updateExistingPivot($surveyId, ['status' => $status->value]);
        return $this->findGuideBySurvey($surveyId, $guide->id);
    }

}
