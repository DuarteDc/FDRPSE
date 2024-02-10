<?php

namespace App\kernel\response;

interface HttpResponse
{

    public static function responseJson(array $data = [], int $status = 200, array $headers = []): void;

    public static function responseDownload($file, int $status = 200, array $headers = []): void;
}
