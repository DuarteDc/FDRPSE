<?php

declare(strict_types=1);

namespace App\kernel\middleware;

use App\kernel\authentication\Auth;
use App\kernel\request\Request;

abstract class Middleware extends Request implements HttpMiddleware
{
	use Auth;
}
