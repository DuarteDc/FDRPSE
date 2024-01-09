<?php

namespace App\Http\Interfaces;

interface HttpRequest
{
    public static function request(): mixed;
    public static function post(string $param): string | null;
    public static function get(string $param): string | null;
    public static function validate(array $validations, array $messages = []);
}
