<?php

namespace App\Http\Response;

use App\Http\Interfaces\HttpResponse;

abstract class Response implements HttpResponse
{
    private static array $codes = [
        200 => '200 OK',
        201 => '201 Created',
        400 => '400 Bad Request',
        401 => '401 Unauthorized',
        403 => '403 Forbidden',
        404 => '404 Not Found',
        422 => '422 Unprocessable Entity',
        500 => '500 Internal Server Error'
    ];

    public static function responseJson($data = [], int $status = 200, array $headers = []): void
    {
        header("Access-Control-Allow-Origin: *");
        header("Cache-Control: no-transform,public,max-age=300,s-maxage=900");
        header("Content-Type: application/json;  charset=UTF-8");
        http_response_code($status);
        header("Status:" . self::$codes[$status]);
        echo json_encode($data);
    }

    public static function responseDownload($file, int $status = 200, array $headers = []): void
    {
        header("Access-Control-Allow-Origin: *");
        header("Cache-Control: no-transform,public,max-age=300,s-maxage=900");
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="' . basename($file) . '"');
        header('Expires: 0');
        header('Pragma: public');
        header('Content-Length: ' . filesize($file));
        http_response_code($status);
        header("Status:" . self::$codes[$status]);
        readfile($file);
        exit;
    }
}
