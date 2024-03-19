<?php

namespace App\infrastructure\requests\section;

use App\kernel\request\Request;
use App\kernel\request\HttpRulesRequest;

class CreateSectionRequest extends Request implements HttpRulesRequest
{

    public static function rules(): array
    {
        return [
            'name'              => 'required|min:8|max:200',
            'binary'            => 'required|boolean',
            'question'          => 'min:8|max:200',
            'can_finish_guide'  => 'boolean',
            'type'              => 'required|min:5|max:200'
        ];
    }

    public static function messages(): array
    {
        return [
            'name:required'             => 'El nombre de la categoría es requerido',
            'name:min'                  => 'El nombre debe contener al menos 8 caracteres',
            'name:max'                  => 'El nombre debe contener máximo 200 caracteres',
            'binary:required'           => 'El tipo de sección es requerido',
            'binary:boolean'            => 'El tipo del campo debe ser true o false',   
            'question:min'              => 'La pregunta de contener al menos 8 caracteres',
            'question:max'              => 'La pregunta supera el máximo de caracteres',
            'can_finish_guide:boolean'  => 'Por favor especifica una opcioón valida para la sección',
            'type:required'             => 'El tipo de la sección es requerido',
            'type:min'                  => 'El tipo de la sección debe ser mayor a 5 caracteres',
            'type:max'                  => 'El tipo de la sección debe contener máximo 5 caracteres',
        ];
    }
}
