<?php

namespace App\kernel\request;

use Rakit\Validation\Validator;

use App\kernel\authentication\Auth;
use App\kernel\response\Response;
use App\kernel\request\HttpRequest;

abstract class Request extends Response implements HttpRequest
{
    use Auth;

    public static function request(): mixed
    {
        return (object) json_decode(file_get_contents('php://input'), true) ?? json_decode(json_encode($_POST));
    }

    public static function post(string $param): string | null
    {
        return isset(static::request()->$param) ? static::request()->$param : null;
    }

    public static function get(string $param): string | null
    {
        return isset($_GET[$param]) ? $_GET[$param] : null;
    }

    public static function validate(array $validations, array $messages = [])
    {
        $validator = new Validator;
        $rules = $validator->make((array) static::request(), $validations);

        $rules->setMessages($messages);
        $rules->validate();

        return $rules->fails() ? static::getFormError($rules) : null;
    }

    private static function getFormError($errors)
    {
        static::responseJson(['message' => $errors->errors()->all()[0]], 400);
        exit();
    }
}
