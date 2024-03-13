<?php

namespace App\kernel\controllers;

use Exception;

use App\kernel\authentication\Auth;
use App\kernel\request\Request;
use App\kernel\views\Views;

abstract class Controller extends Request
{
    use Auth, Views;

    protected function response(mixed $response, int $statusCode = 200)
    {
        if($response instanceof Exception) return $this->response(['message' => $response->getMessage()], $response->getCode());
        $this->responseJson($response, $statusCode);
        exit();
    }
}
