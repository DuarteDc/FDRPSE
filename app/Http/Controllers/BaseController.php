<?php

namespace App\Http\Controllers;

use App\Traits\Auth;
use Rakit\Validation\Validation;
use Rakit\Validation\Validator;

class BaseController
{

    use Auth;

    public Validator $rules;

    public function __construct()
    {
        $this->rules = new Validator;
    }

    protected function validate(array $fields, array $validations, array $messages = []): Validation
    {
        return $this->rules->validate($fields, $validations, $messages);
    }

    private array $status = [
        200 => '200 OK',
        400 => '400 Bad Request',
        401 => '401 Unauthorized',
        422 => '422 Unprocessable Entity',
        403 => '403 Forbidden',
        404 => '404 Not Found',
        500 => '500 Internal Server Error'
    ];

    protected function request(): mixed
    {
        return json_decode(file_get_contents('php://input'), true);
    }

    protected function post(string $param): string
    {
        return isset($this->request()[$param]) ? $this->request()[$param] : "";
    }

    protected function get(string $param): string {
        return isset($_GET[$param]) ? $_GET[$param] : "";
    }

    protected function response(array $data, int $status = 200): void
    {
        header("Access-Control-Allow-Origin: *");
        header("Cache-Control: no-transform,public,max-age=300,s-maxage=900");
        header("Content-Type: application/json;  charset=UTF-8");

        http_response_code($status);

        header('Status: ' . $this->status[$status]);

        echo json_encode($data);
        exit();
    }
}
