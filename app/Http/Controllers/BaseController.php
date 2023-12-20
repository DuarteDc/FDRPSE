<?php

namespace App\Http\Controllers;

use App\Http\Requests\Request;
use App\Http\Response\Response;
use App\Traits\Auth;

class BaseController extends Request
{
    use Auth;
}
