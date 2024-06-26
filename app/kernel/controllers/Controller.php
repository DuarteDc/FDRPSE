<?php

namespace App\kernel\controllers;

use App\kernel\authentication\Auth;

use App\kernel\request\Request;
use App\kernel\views\Views;
use App\shared\traits\ExcelTrait;
use Exception;

abstract class Controller extends Request
{
	use Auth, Views, ExcelTrait;

	protected function response(mixed $response, int $statusCode = 200)
	{
		if ($response instanceof Exception) {
			return $this->responseJson(['message' => $response->getMessage()], $response->getCode() ?? 400);
		}
		$this->responseJson($response, $statusCode);
	}
}
