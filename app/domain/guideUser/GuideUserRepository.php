<?php

namespace App\domain\guideUser;

use App\domain\BaseRepository;
use App\domain\guideUser\GuideUser;
use Illuminate\Database\Eloquent\Collection;

interface GuideUserRepository extends BaseRepository
{
    public function setUser(string $surveyUserId, string $userId): void;
    public function setSurvey(string $surveyUserId, string $surveyId): void;
    public function getCurrentGuideUser(string $guideId, string $userId, string $surveyId);
    public function saveAnswer(GuideUser $surveyUser, mixed $body): GuideUser;
    public function getUserAnwserInCurrentSurvey(string $userId): ?GuideUser;
    public function finalizeGuideUser(string $guideId, string $userId, int $userQualification): GuideUser;
    public function canAvailableSurveyPerUser(string $userId): ?GuideUser;
    public function getDetailsSurveyUser(string $surveyId, string $guideId);
    public function searchByNameAndAreas(string $surveyId, string $guideId, string $name, string $areaId, string $subareaId);
    public function getDetailsByUser(string $surveyId, string $userId): ?GuideUser;
    public function countSurveyUserAnswers(string $surveyId): int;
    public function findCurrentSurveyUser(string $userId): GuideUser;
    public function findUserGuideBySurvey(string $surveyId, string $guideId): ?Collection;
}
