<?php

namespace App\infrastructure\middlewares;

use App\kernel\middleware\Middleware;

class CheckAuthMiddleware extends Middleware
{
    public function handle(): void
    {  
        if (!$this->check($_SERVER['HTTP_SESSION'] ?? '')) {
            $this->responseJson(['message' => '401 - Unauthorized'], 401);
            exit();
        }
    }
}
