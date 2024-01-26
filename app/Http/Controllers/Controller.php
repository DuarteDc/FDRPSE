<?php

namespace App\Http\Controllers;

use App\Http\Requests\Request;
use App\Traits\Auth;

abstract class Controller extends Request
{
    use Auth;

    protected function response(mixed $response, int $statusCode = 200) {
        return $this->responseJson($response, $statusCode);
    }
}
