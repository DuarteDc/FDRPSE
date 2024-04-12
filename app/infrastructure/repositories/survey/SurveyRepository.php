<?php

namespace App\infrastructure\repositories\survey;

use App\domain\survey\Survey;
use App\infrastructure\repositories\BaseRepository;
use App\domain\survey\SurveyRepository as ContractsRepository;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class SurveyRepository extends BaseRepository implements ContractsRepository
{

    public function __construct(private readonly Survey $survey)
    {
        parent::__construct($survey);
    }

    public function findAllSurveys(int $page): Paginator
    {
        return $this->survey::orderBy('id', 'desc')->paginate(5,'*','page',$page);
    }

    public function countTotalsPages(): int
    {
        return ceil($this->survey::count()/ 5);
    }

    public function findSurveyWithDetails(string $surveyId): Survey
    {
        return $this->survey::with('guides')
        
            ->find($surveyId);
    }

    public function startSurvey(): ?Model
    {
        return new Model;
    }

    public function canStartNewSurvey(): bool
    {
        $hasInProgress = $this->survey::where('status', false)->first();
        return $hasInProgress ? false : true;
    }

    public function getCurrentSurvey(): ?Survey
    {
        return $this->survey::with('guides')
            ->where('status', false)
            ->first();
    }

    public function getStatusUsers(string $surveyId): Collection
    {
        return $this->survey::where('id', $surveyId)->get();
    }

    public function endSurvey(Survey $survey): Survey
    {
        $survey->end_date = date('Y-m-d\TH:i:s.000');
        $survey->status   = Survey::FINISHED;
        $survey->save();
        return $survey;
    }

    public function setGuidesToNewSurvey(Survey $survey, array $guidesId): Survey
    {
        $survey->guides()->attach($guidesId);
        return $survey;
    }
}
