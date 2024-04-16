<?php

namespace App\domain\survey;

use App\domain\BaseRepository;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Database\Eloquent\Collection;

interface SurveyRepository extends BaseRepository
{
	public function findAllSurveys(int $page): Paginator;
	public function countTotalsPages(): float;
	public function findSurveyWithDetails(string $surveyId): Survey;
	public function canStartNewSurvey(): bool;
	public function getCurrentSurvey(): Survey|null;
	public function getStatusUsers(string $surveyId): Collection;
	public function endSurvey(Survey $surveyId): Survey;
	public function setGuidesToNewSurvey(Survey $survey, array $guidesId): Survey;
}
