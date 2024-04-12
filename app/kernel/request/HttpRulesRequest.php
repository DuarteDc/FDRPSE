<?php

declare(strict_types=1);

namespace App\kernel\request;

interface HttpRulesRequest
{
    public static function rules(): array;
    public static function messages(): array;
}
