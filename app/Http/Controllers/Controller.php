<?php

namespace App\Http\Controllers;

use App\Http\Requests\Request;
use App\Traits\Auth;
use Exception;

abstract class Controller extends Request
{
    use Auth;

    private function __construct()
    {
    }

    protected function response(mixed $response, int $statusCode = 200)
    {
        if($response instanceof Exception) return $this->response(['message' => $response->getMessage()], $response->getCode());
        $this->responseJson($response, $statusCode);
    }
}
