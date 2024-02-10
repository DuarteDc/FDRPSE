<?php

namespace App\infrastructure\requests\authentication;

use App\kernel\request\Request;
use App\kernel\request\HttpRulesRequest;

class LoginRequest extends Request implements HttpRulesRequest
{

    public static function rules(): array
    {
        return  [
            'username' => 'required',
            'password' => 'required|min:8'
        ];
    }

    public static function messages(): array
    {
        return [];
    }
}
