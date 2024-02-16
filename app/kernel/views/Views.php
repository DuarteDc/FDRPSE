<?php

namespace App\kernel\views;
trait Views
{
    public function view(string $name, $data = [])
    {
        if (!empty($data)) $data = json_decode(json_encode($data));
        require_once __DIR__ . "/../../infrastructure/views/{$name}.php";
    }
}
