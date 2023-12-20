<?php

namespace App\Http\Requests;

use App\Http\Interfaces\HttpRequest;
use App\Http\Response\Response;
use App\Traits\Auth;
use Rakit\Validation\Validator;

abstract class Request extends Response implements HttpRequest
{
    use Auth;

    public static function post(string $param): string | null
    {
        if (isset($_POST[$param])) return $_POST[$param];
        return json_decode(file_get_contents('php://input'), true)[$param] ?? null;
    }

    public static function request(): mixed
    {
        return json_decode(file_get_contents('php://input'), true) ?? json_decode(json_encode($_POST));
    }

    public static function get(string $param): string | null
    {
        return isset($_GET[$param]) ? $_GET[$param] : "";
    }

    public static function validations(array $fields, array $validations, array $messages = [])
    {
        $rules = new Validator;
        $errors = $rules->validate($fields, $validations, $messages);
        if ($errors->fails()) return self::getFormError($errors);
    }

    private static function getFormError($errors)
    {
        self::responseJson($errors->errors()->firstOfAll(), 400);
        exit();
    }
}
