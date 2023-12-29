<?php

namespace App\Traits;

use Exception;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

trait Auth {

    public static function auth()
    {
        $session = $_SERVER['HTTP_SESSION'] ?? '';
        $key = getenv('JWT_SECRET_KEY');
        $decode = JWT::decode($session, new Key($key, 'HS256'));
        return $decode->user;
    }

    public static function createSession($payload)
    {
        $key = getenv('JWT_SECRET_KEY');
        $data = [
            'exp' => strtotime('now') + 3600,
            'user' => $payload,
        ];
        $token = JWT::encode($data, $key, 'HS256');
        return ['user' => $payload, 'session' => $token];
    }

    public static function check(string $token)
    {
        try {
            $key = getenv('JWT_SECRET_KEY');
            $decode = JWT::decode($token, new Key($key, 'HS256'));
            return self::createSession($decode->user);
        } catch (Exception $e) {
            return new Exception($e->getMessage());
        }
    }

}