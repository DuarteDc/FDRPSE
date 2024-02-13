<?php

namespace App\domain\surveyUser;

use App\domain\BaseRepository;

interface SurveyUserRepository extends BaseRepository
{
    public function setUser(string $surveyUserId, string $userId): void;
    public function setSurvey(string $surveyUserId, string $surveyId): void;
    public function getCurrentSurveyUser(string $surveyId, string $userId);
    public function saveAnswer(SurveyUser $surveyUser, mixed $body): SurveyUser;
    public function getUserAnwserInCurrentSurvey(string $userId): ?SurveyUser;
    public function finalizeSurveyUser(string $surveyId, string $userId, int $userQualification): SurveyUser;
    public function canAvailableSurveyPerUser(string $surveyId, string $userId): ?SurveyUser;
    public function getDetailsSurveyUser(string $surveyId): array;
    public function searchByName(string $surveyId, string $name);
}
