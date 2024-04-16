<?php

declare(strict_types=1);

namespace App\infrastructure\requests\dimension;

use App\kernel\request\HttpRulesRequest;
use App\kernel\request\Request;

final class UpdateDimensionRequest extends Request implements HttpRulesRequest
{
	public static function rules(): array
	{
		return [
			'name' => 'required|min:8|max:200',
		];
	}

	public static function messages(): array
	{
		return [
			'name:required' => 'El nombre de la dimensión es requerido',
			'name:min'      => 'El nombre debe contener al menos 8 caracteres',
			'name:max'      => 'El nombre debe contener máximo 200 caracteres',
		];
	}
}
