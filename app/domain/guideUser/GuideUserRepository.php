<?php

declare(strict_types=1);

namespace App\domain\guideUser;

use App\domain\BaseRepository;
use Illuminate\Database\Eloquent\Collection;

interface GuideUserRepository extends BaseRepository
{
    public function setUser(string $surveyUserId, string $userId): void;
    public function setSurvey(string $surveyUserId, string $surveyId): void;
    public function getCurrentGuideUser(string $guideId, string $userId, string $surveyId);
    public function saveAnswer(GuideUser $surveyUser, mixed $body): GuideUser;
    public function getUserAnwserInCurrentSurvey(string $userId): ?GuideUser;
    public function finalizeGuideUser(
        string $surveyId,
        string $guideId,
        string $userId,
        int $userQualification
    ): GuideUser;
    public function canAvailableSurveyPerUser(string $userId): ?GuideUser;
    public function getDetailsSurveyUser(string $surveyId, string $guideId);
    public function searchByNameAndAreas(
        string $surveyId,
        string $guideId,
        string $name,
        string $areaId,
        string $subareaId
    );
    public function getDetailsByUser(string $surveyId, string $userId, string $guideId): ?GuideUser;
    public function countSurveyUserAnswers(string $surveyId): int;
    public function findCurrentSurveyUser(string $userId): GuideUser;
    public function findUserGuideBySurvey(string $surveyId, string $guideId): ?Collection;
    public function clearOldAnswers(GuideUser $guideUser): GuideUser;
    public function countGudesUsersAvailable(string $surveyId, string $guideId): int;
}
