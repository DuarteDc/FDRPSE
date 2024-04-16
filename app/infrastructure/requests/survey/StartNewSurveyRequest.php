<?php

declare(strict_types=1);

namespace App\infrastructure\requests\survey;

use App\kernel\request\HttpRulesRequest;
use App\kernel\request\Request;

final class StartNewSurveyRequest extends Request implements HttpRulesRequest
{
	public static function rules(): array
	{
		return [
			'guides' => 'required|array',
		];
	}

	public static function messages(): array
	{
		return [
			'guides:required' => 'Para poder comenzar una la serie de cuestionarios es necesario agregar cuestionarios',
			'guides:array'    => 'El formato de las preguntas no es valido',
		];
	}
}
