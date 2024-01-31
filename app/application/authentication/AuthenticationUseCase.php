<?php

namespace App\application\authentication;

use App\domain\user\UserRepository;
use Exception;

class AuthenticationUseCase
{

    public function __construct(private readonly UserRepository $userRepository)
    {
    }

    public function signin(string $email, string $password)
    {
        $user = $this->userRepository->findByEmail($email);
        if (!$user) return new Exception('El usuario o contraseña no es valido', 400);
        //TODO validate user password
        return $user;
    }

    public function checkUserSession(mixed $user)
    {
        if (!$user) return new Exception('Unauthorized', 401);
        $user = $this->userRepository->findOne($user->id);
        return $user ? $user : new Exception('Unauthorized', 401);
    }
}
