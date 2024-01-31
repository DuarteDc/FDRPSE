<?php

namespace App\Traits;

use App\domain\user\User;
use Exception;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use stdClass;

trait Auth
{

    public static function auth()
    {
        $session = $_SERVER['HTTP_SESSION'] ?? '';
        $key = getenv('JWT_SECRET_KEY');
        $decode = JWT::decode($session, new Key($key, 'HS256'));
        return $decode->user;
    }

    public static function createSession(User $payload)
    {
        $key = getenv('JWT_SECRET_KEY');
        $data = [
            // 'exp' => strtotime('now') + 3600,
            'user' => $payload,
        ];
        $token = JWT::encode($data, $key, 'HS256');
        return ['user' => $payload, 'session' => $token];
    }

    public static function check(string $token): ?stdClass
    {
        try {
            if (!isset($token)) return null;
            $key = getenv('JWT_SECRET_KEY');
            $session = JWT::decode($token, new Key($key, 'HS256'));
            return $session ? $session->user : null;
        } catch (Exception $e) {
            return null;
        }
    }
}
