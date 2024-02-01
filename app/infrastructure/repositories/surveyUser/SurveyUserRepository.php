<?php

namespace App\infrastructure\repositories\surveyUser;

use App\domain\surveyUser\SurveyUser;
use Illuminate\Database\Eloquent\Model;

use App\infrastructure\repositories\BaseRepository;
use App\domain\surveyUser\SurveyUserRepository as ConfigSurveyUserRepository;

class SurveyUserRepository extends BaseRepository implements ConfigSurveyUserRepository
{

    public function __construct(private readonly SurveyUser $surveyUser)
    {
        parent::__construct($surveyUser);
    }

    public function setUser(string $surveyUserId, string $userId): void
    {
        $this->surveyUser::find($surveyUserId)->attach($userId);
    }

    public function setSurvey(string $surveyUserId, string $surveyId): void
    {
        $this->surveyUser::find($surveyUserId)->attach($surveyId);
    }

    public function getCurrentSurveyUser(string $surveyId, string $userId): SurveyUser
    {
        $surveyUser = $this->surveyUser::Where('survey_id', $surveyId)->where('user_id', $userId)->first();
        return $this->surveyUser::with(['survey' => function($query) {
            $query->where('status', true);
        }])->first();

        return $surveyUser;
        return $surveyUser ? $surveyUser : $this->create(['survey_id' => $surveyId, 'user_id' => $userId]);
    }

    public function saveAnswer(SurveyUser $surveyUser, mixed $body): SurveyUser
    {
        $surveyUser->answer = $body;
        $surveyUser->save();
        return $surveyUser;
    }
}
