<?php

namespace App\infrastructure\repositories\survey;

use App\infrastructure\repositories\BaseRepository;
use App\domain\survey\SurveyRepository as ConfigSurveyRepository;
use Illuminate\Database\Eloquent\Model;

class SurveyRepository extends BaseRepository implements ConfigSurveyRepository
{
    
    public function __construct(private readonly Model $model) {
        parent::__construct($model);
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
        $hasInProgress = $this->model::where('status', false)->first();
        return $hasInProgress ? false : true;
    }

    

}
