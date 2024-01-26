<?php

namespace App\infrastructure\requests\domain;

use App\Http\Interfaces\HttpRulesRequest;
use App\Http\Requests\Request;

class CreateDomainRequest extends Request implements HttpRulesRequest
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
            'name:required' => 'El nombre del dominio es requerido',
            'name:min' => 'El nombre debe contener al menos 8 caracteres',
            'name:max' => 'El nombre debe contener máximo 200 caracteres',
        ];
    }
}
