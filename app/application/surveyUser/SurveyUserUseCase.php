<?php

declare(strict_types=1);

namespace App\application\surveyUser;

use App\domain\surveyUser\SurveyUserRepository;

final class SurveyUserUseCase
{
	public function __construct(private readonly SurveyUserRepository $surveyUserRepository) {}
}
