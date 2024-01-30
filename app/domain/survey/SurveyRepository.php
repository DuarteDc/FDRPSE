<?php

namespace App\domain\survey;

use App\domain\BaseRepository;

interface SurveyRepository extends BaseRepository
{
    public function setSurvey(): void;
    public function canStartNewSurvey(): bool;
}
