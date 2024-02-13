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
    
    public function __construct(private readonly Survey $survey) {
        parent::__construct($survey);
    }

    public function findAllSurveys(): Paginator
    {
        return $this->survey::orderBy('id','desc')->simplePaginate();
    }

    public function startSurvey(): ?Model
    {
        return new Model;
    }

    public function setSurvey(): void
    {

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

}
