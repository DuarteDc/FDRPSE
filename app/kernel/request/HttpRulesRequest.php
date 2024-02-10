<?php


namespace App\kernel\request;

interface HttpRulesRequest
{
    public static function rules(): array;
    public static function messages(): array;
}
