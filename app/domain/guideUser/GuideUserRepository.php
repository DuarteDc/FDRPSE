<?php

namespace App\domain\guideUser;

use App\domain\BaseRepository;
use App\domain\guideUser\GuideUser;

interface GuideUserRepository extends BaseRepository
{
    public function setUser(string $surveyUserId, string $userId): void;
    public function setSurvey(string $surveyUserId, string $surveyId): void;
    public function getCurrentGuideUser(string $guideId, string $userId);
    public function saveAnswer(GuideUser $surveyUser, mixed $body): GuideUser;
    public function getUserAnwserInCurrentSurvey(string $userId): ?GuideUser;
    public function finalizeSurveyUser(string $surveyId, string $userId, int $userQualification): GuideUser;
    public function canAvailableSurveyPerUser(string $surveyId, string $userId): ?GuideUser;
    public function getDetailsSurveyUser(string $surveyId): array;
    public function searchByName(string $surveyId, string $name, string $areaId);
    public function getDetailsByUser(string $surveyId, string $userId): ?GuideUser;
    public function countSurveyUserAnswers(string $surveyId): int;
    public function findCurrentSurveyUser(string $userId): GuideUser;
}
