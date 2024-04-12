<?php

declare(strict_types=1);

namespace App\kernel\views;

trait Views
{
    public function view(string $name, $data = [])
    {
        if (!empty($data)) {
            $data = json_decode(json_encode($data));
        }
        require_once __DIR__ . "/../../infrastructure/views/{$name}.php";
    }

    public function renderBufferView(string $name, mixed $data = []): string
    {
        ob_start();
        if (!empty($data)) {
            $data = json_decode(json_encode($data));
        }
        require_once __DIR__ . "/../../infrastructure/views/{$name}.php";
        return ob_get_clean();
    }
}
