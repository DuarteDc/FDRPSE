<?php


namespace App\Http\Requests\Auth;

use App\Http\Requests\Request;

class LoginRequest extends Request
{

    public function rules()
    {
        $this->validations(
            $this->request(),
            [
                'email' => 'email|required',
                'password' => 'required|min:55'
            ],
        );
    }
}
