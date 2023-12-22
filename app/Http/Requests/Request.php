<?php

namespace App\Http\Requests;

use App\Http\Interfaces\HttpRequest;
use App\Http\Response\Response;
use App\Traits\Auth;
use Rakit\Validation\Validator;

abstract class Request extends Response implements HttpRequest
{
    use Auth;
        
    public static function request(): mixed
    {
        return json_decode(file_get_contents('php://input'), true) ?? json_decode(json_encode($_POST));
    }

    public static function post(string $param): string | null
    {
        return isset(static::request()[$param]) ?? null;
    }
    
    public static function get(string $param): string | null
    {
        return isset($_GET[$param]) ? $_GET[$param] : null;
    }

    public static function validate(array $validations, array $messages = [])
    {
        $validator = new Validator;
        $rules = $validator->make(static::request(), $validations);

        $rules->setMessages($messages);
        $rules->validate();

        return $rules->fails() ? static::getFormError($rules) : null;
    }

    private static function getFormError($errors)
    {
        static::responseJson($errors->errors()->firstOfAll(), 400);
        exit();
    }
}
