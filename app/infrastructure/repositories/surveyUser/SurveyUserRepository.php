<?php

namespace App\infrastructure\repositories\surveyUser;

use App\domain\surveyUser\SurveyUser;
use Illuminate\Database\Eloquent\Model;

use App\infrastructure\repositories\BaseRepository;
use App\domain\surveyUser\SurveyUserRepository as ConfigSurveyUserRepository;

class SurveyUserRepository extends BaseRepository implements ConfigSurveyUserRepository
{

    public function __construct(private readonly Model $model)
    {
        parent::__construct($model);
    }

    public function setUser(string $surveyUserId, string $userId): void
    {
        $this->model::find($surveyUserId)->attach($userId);
    }

    public function setSurvey(string $surveyUserId, string $surveyId): void
    {
        $this->model::find($surveyUserId)->attach($surveyId);
    }

    public function getCurrentSurveyUser(string $surveyId, string $userId): SurveyUser
    {
        $pivot =  $this->model::where('survey_id', $surveyId)->where('user_id', $userId)->first();
        return $pivot ? $pivot : $this->create(['survey_id' => $surveyId, 'user_id' => $userId]);
    }

    public function saveAnswer(SurveyUser $surveyUser, mixed $body): SurveyUser
    {
        $surveyUser->answer = $body;
        return $surveyUser;
        return  $surveyUser->survey->save();
    }
}
