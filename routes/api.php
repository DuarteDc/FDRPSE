<?php

use Bramus\Router\Router;

$router = new Router();

$router->setNamespace('App\Http\Controllers');

$router->mount('/api.*', function () use ($router) {
    $router->post('/login', 'AuthController@login');

    $router->get('/questions', 'QuestionController@index');
    $router->post('/questions', 'QuestionController@save');

});
$router->run();
