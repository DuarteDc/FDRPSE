<?php

namespace App\domain\survey;

use App\domain\survey\Survey;
use App\domain\BaseRepository;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Database\Eloquent\Collection;

interface SurveyRepository extends BaseRepository
{
    public function findAllSurveys(): Paginator;
    public function canStartNewSurvey(): bool;
    public function getCurrentSurvey(): Survey | null;
    public function getStatusUsers(string $surveyId): Collection;
    public function endSurvey(string $surveyId): Survey;
}
