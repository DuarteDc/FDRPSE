<?php

namespace App\infrastructure\requests\dimension;

use App\kernel\request\Request;
use App\kernel\request\HttpRulesRequest;

class CreateDimensionRequest extends Request implements HttpRulesRequest
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
            'name:required' => 'El nombre de la categoría es requerido',
            'name:min' => 'El nombre debe contener al menos 8 caracteres',
            'name:max' => 'El nombre debe contener máximo 200 caracteres',
        ];
    }
}
