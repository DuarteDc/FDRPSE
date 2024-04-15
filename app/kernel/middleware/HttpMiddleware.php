<?php

declare(strict_types=1);

namespace App\kernel\middleware;

interface HttpMiddleware
{
	public function handle(): void;
}
