<?php

namespace App\domain\guideSurvey;

use App\domain\BaseRepository;
use App\domain\section\Section;

interface GuideSurveyRepository extends BaseRepository
{
    public function findGuideInProgress(): ?GuideSurvey;

    public function findQuestionInsideGuide(GuideSurvey $guideSurvey, string $questionId): ?Section;
}
