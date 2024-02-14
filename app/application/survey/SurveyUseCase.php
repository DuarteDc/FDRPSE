<?php


namespace App\application\survey;

use App\domain\user\UserRepository;
use Exception;

class SurveyUseCase
{

    public function __construct(private readonly SurveyService $surveyService, private readonly UserRepository $userRepository)
    {
    }

    public function getAllSurveys()
    {
        return $this->surveyService->getSurvys();
    }

    public function startNewSurvey()
    {
        return $this->surveyService->startSurvey();
    }

    public function saveAnswers(mixed $body)
    {
        return $this->surveyService->saveAnswersByUser($body);
    }

    public function getQuestionsByUser()
    {
        return $this->surveyService->getQuestionInsideSection();
    }

    public function startSurveyByUser()
    {
        return $this->surveyService->setSurveyToUser();
    }

    public function finalizeSurveyByUser()
    {
        return $this->surveyService->finalzeUserSurvey();
    }

    public function getInProgressSurvey()
    {
        return $this->surveyService->existSurveyInProgress();
    }

    public function findSurveyById(string $surveyId)
    {
        $survey =  $this->surveyService->findOneSurvey($surveyId);
        return $survey ? ['survey' => $survey] : new Exception('La encuesta no existe o no esta disponible', 404);
    }

    public function getOneSurvey(string $surveyId)
    {
        return ['survey' => $this->surveyService->getSurveyDetails($surveyId)];
    }

    public function findSurveyByName(string $surveyId, string $name, string $areaId)
    {
        return ['survey' => $this->surveyService->findSurveyByName($surveyId, $name, $areaId)];
    }

    public function findUserDetails(string $surveyId, string $userId)
    {
        $surveyUser = $this->surveyService->getDetailsByUser($surveyId, $userId);
        if ($surveyUser instanceof Exception) return $surveyUser;
        return ['survey_user' => $surveyUser];
    }

    public function getUserWithoutSurvey()
    {
        $users = $this->userRepository->countTotalAvailableUsers();
        return ['users' => $users];
    }

}
