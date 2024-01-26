<?php


namespace App\Http\Interfaces;

interface HttpRulesRequest
{
    public static function rules(): array;
    public static function messages(): array;
}
