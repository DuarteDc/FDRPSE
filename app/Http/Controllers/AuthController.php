<?php

namespace App\Http\Controllers;

use App\Http\Controllers\BaseController;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\User;

class AuthController extends BaseController
{

    public function login()
    {
        $user = User::where('email', $this->post('email'))->first();

        if (!$user->verifyPassword($this->post('password'), $user->password)) return $this->responseJson(['message' => 'El usuario o contraseña no son validos'], 400);
        $this->responseJson($this->createSession($user));
    }


    public function xd()
    {
        echo "xee";
    }
}
