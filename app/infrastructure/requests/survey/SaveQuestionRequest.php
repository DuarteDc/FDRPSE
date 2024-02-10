<?php

namespace App\infrastructure\requests\survey;

use App\kernel\request\Request;
use App\kernel\request\HttpRulesRequest;

class SaveQuestionRequest extends Request implements HttpRulesRequest
{

    public static function rules(): array
    {
        return [
            'questions'      => 'required|array',
            // 'section_id'     => 'required|integer'
        ];
    }

    public static function messages(): array
    {
        return [
            'questions:required'     => 'Las preguntas son requeridas',
            'questions:array'             => 'El formato de las preguntas no es valido',
            // 'section_id:required'    => 'La sección es requerida',
            // 'section_id:integer'     => 'La sección no es valida',
        ];
    }
}
