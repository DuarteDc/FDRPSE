<?php

namespace App\infrastructure\repositories\surveyUser;

use App\domain\surveyUser\SurveyUser;
use App\infrastructure\repositories\BaseRepository;
use App\domain\surveyUser\SurveyUserRepository as ContractsRepository;

class SurveyUserRepository extends BaseRepository implements ContractsRepository
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

    public function finalizeSurveyUser(string $surveyId, string $userId, int $userQualification): SurveyUser
    {
        $surveyUser = $this->surveyUser::where('survey_id', $surveyId)->where('user_id', $userId)->first();
        $surveyUser->status = SurveyUser::FINISHED;
        $surveyUser->total  = $userQualification;
        $surveyUser->save();
        return $surveyUser;
    }

    public function canAvailableSurveyPerUser(string $surveyId, string $userId): ?SurveyUser
    {
        return $this->surveyUser::where('survey_id', $surveyId)->where('user_id', $userId)->first();
    }

    public function getDetailsSurveyUser(string $surveyId): array
    {
        return $this->surveyUser::where('survey_id', $surveyId)
            ->with(['user:id,nombre,apellidoP,apellidoM,id_area', 'user.area:id,nombreArea'])
            ->get(['user_id', 'total', 'status'])
            ->toArray();
    }

    public function searchByName(string $surveyId, string $name, string $areaId)
    {
        $survey =  $this->getDetailsSurveyUser($surveyId);
        return array(...array_filter($survey, function ($survey) use ($name, $areaId) {
            if (!$areaId) return (str_contains($survey['user']['nombre'], $name) || str_contains($survey['user']['apellidoP'], $name)) ? $survey : null;
            return ((str_contains($survey['user']['nombre'], $name) || str_contains($survey['user']['apellidoP'], $name)) && $survey['user']['area']['id'] == $areaId) ? $survey : null;
        }));
    }

    public function getDetailsByUser(string $surveyId, string $userId): ?SurveyUser
    {
        return $this->surveyUser::where('survey_id', $surveyId)->where('user_id', $userId)
            ->with(['user:id,nombre,apellidoP,apellidoM,id_area', 'user.area:id,nombreArea'])
            ->first(['user_id', 'total', 'status', 'answers']);
    }

    public function findCurrentSurveyUser(string $userId): SurveyUser
    {
        return $this->surveyUser::where('user_id', $userId)
            ->with(['user:id,nombre,apellidoP,apellidoM,id_area', 'user.area:id,nombreArea'])
            ->first(['user_id', 'total', 'status', 'answers']);
    }

    public function countSurveyUserAnswers(string $surveyId): int
    {
        return $this->surveyUser::where('survey_id', $surveyId)->count();
    }
}
