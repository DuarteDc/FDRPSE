<?php

namespace App\kernel\middleware;

interface HttpMiddleware
{
    public function handle(): void;
}
