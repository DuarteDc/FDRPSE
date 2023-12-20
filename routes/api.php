<?php

use App\Http\Controllers\AuthController;
use App\Http\Requests\Auth\LoginRequest;
use Routes\Router;

$router = new Router();

$router->mount('/api/*', function () use ($router) {
    $router->get('/', [AuthController::class, 'xd']);
    
    $router->post('/signin', [AuthController::class, 'login'], LoginRequest::class);
});
$route->run();
