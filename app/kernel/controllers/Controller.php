<?php

namespace App\kernel\controllers;

use Exception;

use App\kernel\authentication\Auth;
use App\kernel\request\Request;

abstract class Controller extends Request
{
    use Auth;

    protected function response(mixed $response, int $statusCode = 200)
    {
        if($response instanceof Exception) return $this->response(['message' => $response->getMessage()], $response->getCode());
        $this->responseJson($response, $statusCode);
    }
}
