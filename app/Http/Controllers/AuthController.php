<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Controllers\Controller;

class AuthController extends Controller
{

    public function login()
    {
        $this->validate(
            [
                'email' => 'email|required',
                'password' => 'required|min:8'
            ],
            [
                'email' => 'El correo electronico es requerido',
                'password:required' => 'La contraseña es requerida',
                'password:min' => 'La contraseña debe contener al menos 8 caracteres'
            ]
        );

        $user = User::where('email', $this->post('email'))->first();

        //if (!$user || !$user->verifyPassword($this->post('password'), $user->password)) return $this->responseJson(['message' => 'El usuario o contraseña no son validos'], 400);

        if (!$user || $user->password != $this->post('password')) return $this->responseJson(['message' => 'El usuario o contraseña no son validos'], 400);
        $this->responseJson($this->createSession($user));
    }
}
