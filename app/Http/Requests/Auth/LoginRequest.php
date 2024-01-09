<?php

namespace App\Http\Requests\Auth;

use App\Http\Interfaces\HttpRulesRequest;
use App\Http\Requests\Request;

class LoginRequest extends Request implements HttpRulesRequest
{

    public static function rules()
    {
        
        return  [
                'email' => 'email|required',
                'password' => 'required|min:55'
        ];
    }
}
