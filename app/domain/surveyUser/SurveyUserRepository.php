<?php

namespace App\domain\surveyUser;

use App\domain\BaseRepository;
use App\domain\survey\Survey;

interface SurveyUserRepository extends BaseRepository
{
    public function setUser(string $surveyUserId, string $userId): void;
    public function setSurvey(string $surveyUserId, string $surveyId): void;

    public function getCurrentSurveyUser(string $surveyId, string $userId): SurveyUser;
    public function saveAnswer(SurveyUser $surveyUser, mixed $body): SurveyUser;
}

