<?php

namespace App\kernel\middleware;

use App\kernel\request\Request;
use App\kernel\middleware\HttpMiddleware;
use App\kernel\authentication\Auth;

abstract class Middleware extends Request implements HttpMiddleware
{    
    use Auth;
}
