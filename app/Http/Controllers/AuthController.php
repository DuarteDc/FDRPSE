<?php 

namespace App\Http\Controllers;

use App\Http\Controllers\BaseController;
use App\Models\User;

class AuthController extends BaseController {

    public function login() {
        $rules = $this->validate(
            $this->request(),
            ['email' => 'email|required', 'password' => 'required']
        );
        if($rules->fails()) return $this->response($rules->errors()->firstOfAll(), 400);

        $user = User::where('email', $this->post('email'))->first();

        if(!$user->verifyPassword($this->post('password'), $user->password)) return $this->response(['message' => 'El usuario o contraseña no son validos'], 400);
        $this->response($this->createSession($user));

    }

}