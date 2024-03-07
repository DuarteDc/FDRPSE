<?php


namespace App\application\survey;

use App\domain\area\Area;
use App\domain\area\AreaRepository;
use App\domain\user\User;
use App\domain\user\UserRepository;
use Exception;

class SurveyUseCase
{

    public function __construct(private readonly SurveyService $surveyService, private readonly UserRepository $userRepository, private readonly AreaRepository $areaRepository)
    {
    }

    public function getAllSurveys()
    {
        return $this->surveyService->getSurvys();
    }

    public function startNewSurvey(mixed $areas)
    {
        $survey = $this->surveyService->startSurvey();
        if ($survey instanceof Exception) return $survey;
        //return ['survey' => $survey, 'message' => 'El cuestionario se creo correctamente'];

        $countAreas = $this->areaRepository->countAreasByAreasId(array_column($areas, 'id'));
        if ($countAreas !== count($areas)) return new Exception('Por favor verifica que las areas sean correctas', 400);
        $surveyUsers = [];
        $users = $this->userRepository->getAvailableUsers();
        $users->each(function (User $user) use($surveyUsers, $survey) {
            $surveyUsers = [...$surveyUsers, ['user_id', $user->id, 'survey_id' => $survey->id]];
        });

        return $surveyUsers;


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

    public function finalizeSurvey(string $surveyId)
    {
        $survey = $this->surveyService->findOneSurvey($surveyId);
        if (!$survey) return new Exception('El cuestionario no existe o no esta disponible', 404);
        if ($survey->status) return new Exception('El cuestionario ya ha sido finalizado', 404);
        $totalSurveyUsers = $this->surveyService->getTotalUsersInSurvey($surveyId);
        $totalUsers = $this->userRepository->countTotalAvailableUsers();
        $users = $this->calculateUsersHaveToAnswers($totalUsers);
        return $totalSurveyUsers >= $users ? $this->surveyService->endSurvey($surveyId) : new Exception("El cuestionario no puede ser finalizado, es necesario {$users} usuarios o más", 400);
    }

    private function calculateUsersHaveToAnswers(int $usersCount): int
    {
        $totalUsers = 0.9604 * $usersCount;
        $totalConst = 0.0025 * ($usersCount - 1) + 0.9604;
        return round($totalUsers / $totalConst);
    }

    public function getDataToGenerateSurveyUserResume(string $userId)
    {
        $surveyUser =  $this->surveyService->getLastSurveyByUser($userId);
        return !$surveyUser ? new Exception('El cuestionario no esta disponible', 404) : $surveyUser;
    }
}
