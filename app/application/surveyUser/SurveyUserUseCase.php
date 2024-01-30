<?php

namespace App\application\surveyUser;

use App\domain\surveyUser\SurveyUserRepository;

class SurveyUserUseCase
{
    public function __construct(private readonly SurveyUserRepository $surveyUserRepository)
    {
    }
}
