<?php

namespace App\infrastructure\requests\question;

use App\kernel\request\HttpRulesRequest;
use App\kernel\request\Request;

final class CreateQuestionRequest extends Request implements HttpRulesRequest
{
	public static function rules(): array
	{
		return [
			'name'             => 'required|min:8|max:1000',
			'section_id'       => 'required|numeric',
			'dimension_id'     => 'numeric',
			'qualification_id' => 'numeric',
			'type'             => 'required',
		];
	}

	public static function messages(): array
	{
		return [
			'name:required'            => 'El nombre de la pregunta es requerido',
			'name:min'		               => 'El nombre debe contener al menos 8 caracteres',
			'name:max'		               => 'El nombre debe contener máximo 1000 caracteres',
			'section_id:required' 	    => 'La sección es requerida',
			'section_id:numeric'       => 'La sección no es valida',
			'dimension_id:numeric'     => 'La dimensión no es valida',
			'qualification_id:numeric' => 'La calificación no es valida',
			'type:required'            => 'El tipo de la pregunta no es valida',
		];
	}
}
