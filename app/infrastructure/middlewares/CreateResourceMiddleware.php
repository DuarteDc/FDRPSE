<?php


namespace App\infrastructure\middlewares;

use App\domain\survey\SurveyRepository;
use App\kernel\middleware\Middleware;

class CreateResourceMiddleware extends Middleware
{

    public function __construct(private readonly SurveyRepository $surveyRepository)
    {
    }

    public function handle(): void
    {
        // if (!$this->surveyRepository->canStartNewSurvey()) {
        //     $this->responseJson(['message' => 'No es posible continuar porque existe un cuestionario en curso'], 400);
        //     exit();
        // }
    }
}
