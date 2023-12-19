<?php

use Bramus\Router\Router;

$router = new Router;

$router->setNamespace('\App\Http\Controllers');

$router->mount('/api(/.*)?', function () use ($router) {
    $router->post('/signin', 'AuthController@login');
});



$router->run();
