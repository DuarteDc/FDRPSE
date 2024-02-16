<?php

namespace App\infrastructure\repositories\survey;

use App\domain\survey\Survey;
use App\infrastructure\repositories\BaseRepository;
use App\domain\survey\SurveyRepository as ConfigSurveyRepository;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class SurveyRepository extends BaseRepository implements ConfigSurveyRepository
{

    public function __construct(private readonly Survey $survey)
    {
        parent::__construct($survey);
    }

    public function findAllSurveys(): Paginator
    {
        return $this->survey::orderBy('id', 'desc')->simplePaginate();
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
        return $this->survey::where('status', false)->first();
    }

    public function getStatusUsers(string $surveyId): Collection
    {
        return $this->survey::where('id', $surveyId)->get();
    }

    public function endSurvey(string $surveyId): Survey
    {
        $survey = $this->survey::find($surveyId);
        $survey->end_date = date('Y-m-d\TH:i:s.000');
        $survey->status   = Survey::FINISHED;
        $survey->save();
        return $survey;
    }
}
