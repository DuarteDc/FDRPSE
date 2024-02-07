<?php

namespace App\infrastructure\requests\authentication;

use App\Http\Interfaces\HttpRulesRequest;
use App\Http\Requests\Request;

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
