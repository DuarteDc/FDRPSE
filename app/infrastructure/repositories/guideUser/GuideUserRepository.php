<?php

namespace App\infrastructure\repositories\guideUser;

use App\domain\guideUser\GuideUser;
use App\infrastructure\repositories\BaseRepository;
use App\domain\guideUser\GuideUserRepository as ContractsRepository;

class GuideUserRepository extends BaseRepository implements ContractsRepository
{

    public function __construct(private readonly GuideUser $guideUser)
    {
        parent::__construct($guideUser);
    }

    public function setUser(string $surveyUserId, string $userId): void
    {
        $this->guideUser::find($surveyUserId)->attach($userId);
    }

    public function setSurvey(string $surveyUserId, string $surveyId): void
    {
        $this->guideUser::find($surveyUserId)->attach($surveyId);
    }

    public function getCurrentGuideUser(string $guideId, string $userId)
    {
        $guideUser = $this->guideUser::Where('guide_id', $guideId)
            ->where('user_id', $userId)
            ->first();
            
        return $guideUser ? $guideUser : $this->create(['guide_id' => $guideId, 'user_id' => $userId]);
    }

    public function saveAnswer(GuideUser $guideUser, mixed $body): GuideUser
    {
        $guideUser->answers = $body;
        $guideUser->save();
        return $guideUser;
    }

    public function getUserAnwserInCurrentSurvey(string $userId): ?GuideUser
    {
        return $this->guideUser::where('status', false)->where('user_id', $userId)->first();
    }

    public function finalizeGuideUser(string $guideId, string $userId, int $userQualification): GuideUser
    {
        $surveyUser = $this->guideUser::where('guide_id', $guideId)
            ->where('user_id', $userId)
            ->first();
        $surveyUser->status = GuideUser::FINISHED;
        $surveyUser->total  = $userQualification;
        $surveyUser->save();
        return $surveyUser;
    }

    public function canAvailableSurveyPerUser(string $userId): ?GuideUser
    {
        return $this->guideUser::where('user_id', $userId)
            ->where('status', false)
            ->first();
    }

    public function getDetailsSurveyUser(string $surveyId): array
    {
        return $this->guideUser::where('survey_id', $surveyId)
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

    public function getDetailsByUser(string $surveyId, string $userId): ?GuideUser
    {
        return $this->guideUser::where('survey_id', $surveyId)->where('user_id', $userId)
            ->with(['user:id,nombre,apellidoP,apellidoM,id_area', 'user.area:id,nombreArea'])
            ->first(['user_id', 'total', 'status', 'answers']);
    }

    public function findCurrentSurveyUser(string $userId): GuideUser
    {
        return $this->guideUser::where('user_id', $userId)
            ->with(['user:id,nombre,apellidoP,apellidoM,id_area', 'user.area:id,nombreArea'])
            ->first(['user_id', 'total', 'status', 'answers']);
    }

    public function countSurveyUserAnswers(string $surveyId): int
    {
        return $this->guideUser::where('survey_id', $surveyId)->count();
    }
}
