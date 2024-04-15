<?php

declare(strict_types=1);

namespace App\infrastructure\requests\question;

use App\kernel\request\HttpRulesRequest;
use App\kernel\request\Request;

final class CreateQuestionRequest extends Request implements HttpRulesRequest
{
	public static function rules(): array
	{
		return [
			'name' => 'required|min:8|max:1000',
			'section_id' => 'required|numeric',
			'dimension_id' => 'numeric',
			'qualification_id' => 'numeric',
			'type' => 'required',
		];
	}

	public static function messages(): array
	{
		return [];
	}
}
