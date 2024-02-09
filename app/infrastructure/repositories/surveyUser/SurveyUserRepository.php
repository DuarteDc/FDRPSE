<?php

namespace App\infrastructure\repositories\surveyUser;

use App\domain\surveyUser\SurveyUser;
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

    public function getCurrentSurveyUser(string $surveyId, string $userId)
    {
        $surveyUser = $this->surveyUser::Where('survey_id', $surveyId)->where('user_id', $userId)->first();
        return $surveyUser ? $surveyUser : $this->create(['survey_id' => $surveyId, 'user_id' => $userId]);
    }

    public function saveAnswer(SurveyUser $surveyUser, mixed $body): SurveyUser
    {
        $surveyUser->answers = $body;
        $surveyUser->save();
        return $surveyUser;
    }

    public function getUserAnwserInCurrentSurvey(string $userId): ?SurveyUser
    {
        return $this->surveyUser::where('status', false)->where('user_id', $userId)->first();
    }

    public function finalizeSurveyUser(string $surveyId, string $userId): SurveyUser
    {
        $surveyUser = $this->surveyUser::where('survey_id', $surveyId)->where('user_id', $userId)->first();
        $surveyUser->status  = SurveyUser::FINISHED;
        $surveyUser->save();
        return $surveyUser;
    }

    public function canAvailableSurveyPerUser(string $surveyId, string $userId): ?SurveyUser
    {
        return $this->surveyUser::where('survey_id', $surveyId)->where('user_id', $userId)->first();
    }

}
