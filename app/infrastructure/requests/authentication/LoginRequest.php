<?php

namespace App\infrastructure\requests\authentication;

use App\kernel\request\Request;
use App\kernel\request\HttpRulesRequest;

class LoginRequest extends Request implements HttpRulesRequest
{

    public static function rules(): array
    {
        return  [
            'username' => 'required|min:8',
            'password' => 'required|min:4',
        ];
    }

    public static function messages(): array
    {
        return [
            'username:required'         => 'El nombre de usuario es requerido',
            'name:min'                  => 'El nombre de usuario debe contener al menos 8 caracteres',
            'password:required'         => 'La contraseña es requerida',
            'password:min'              => 'La contraseña debe contener al menos 8 caracteres',
        ];
    }
}
