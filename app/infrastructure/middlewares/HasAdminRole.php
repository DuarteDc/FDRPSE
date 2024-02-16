<?php

namespace App\infrastructure\middlewares;

use App\domain\user\User;
use App\kernel\middleware\Middleware;

class HasAdminRole extends Middleware
{

    public function handle(): void
    {
        $user = $this->check($_SERVER['HTTP_SESSION'] ?? '');
        if ($user && $user->tipo === User::ADMIN) {
            $this->responseJson(['message' => 'Forbidden'], 403);
            exit();
        }
    }
}
