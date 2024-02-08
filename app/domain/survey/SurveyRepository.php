<?php

namespace App\domain\survey;

use App\domain\survey\Survey;
use App\domain\BaseRepository;
use Illuminate\Contracts\Pagination\Paginator;

interface SurveyRepository extends BaseRepository
{
    public function findAllSurveys(): Paginator;
    public function setSurvey(): void;
    public function canStartNewSurvey(): bool;
    public function getCurrentSurvey(): Survey | null;
}
