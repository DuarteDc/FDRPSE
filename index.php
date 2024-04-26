<?php

$url = 'http://localhost:8001/api';

// Obtiene los encabezados de la respuesta HTTP
$headers = get_headers($url);

// Obtiene el código de estado HTTP (por ejemplo, 'HTTP/1.1 200 OK')
$statusCode = explode(' ', $headers[0]);

print_r(array_filter($headers, fn($header, $__) => str_contains($header, 'Status'), ARRAY_FILTER_USE_BOTH));