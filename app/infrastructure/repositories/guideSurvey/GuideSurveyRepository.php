<?php

namespace App\infrastructure\repositories\guideSurvey;

use App\domain\guideSurvey\GuideSurvey;
use App\domain\guideSurvey\GuideSurveyRepository as ContractRepository;
use App\domain\section\Section;
use App\infrastructure\repositories\BaseRepository;

class GuideSurveyRepository extends BaseRepository implements ContractRepository
{

    public function __construct(private readonly GuideSurvey $guideSurvey)
    {
        parent::__construct($guideSurvey);
    }

    public function findGuideInProgress(): ?GuideSurvey
    {
        return $this->guideSurvey::where('status', false)
            ->orderBy('id', 'asc')
            ->first();
    }

    public function findQuestionInsideGuide(GuideSurvey $guideSurvey, string $questionId): ?Section
    {
        $guide = $guideSurvey->guides()
            ->where('id', $guideSurvey->guide_id)
            ->first();

        return $guide->sections()->where('id', $questionId)->first();
    }
}
