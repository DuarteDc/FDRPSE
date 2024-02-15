<?php

namespace App\kernel\middleware;

use App\kernel\authentication\Auth;
use App\kernel\request\Request;

class Middleware extends Request
{
    use Auth;

}
