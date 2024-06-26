<?php

namespace App\kernel\middleware;

use App\kernel\authentication\Auth;
use App\kernel\request\Request;

abstract class Middleware extends Request implements HttpMiddleware
{
	use Auth;
}
