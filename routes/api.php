<?php

use App\Models\User;
use Bramus\Router\Router;

$router = new Router();

$router->setNamespace('App\Http\Controllers');

function sendCorsHeaders()
{
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json; charset=utf-8');
    header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept, session");
    header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, PATCH');
    header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
    header("Cache-Control: post-check=0, pre-check=0", false);
    header("Pragma: no-cache");
}

$router->options('/api.*', function () {
    sendCorsHeaders();
});

$router->mount('/api.*', function () use ($router) {

    $router->get('/me', 'AuthController@me');
    $router->post('/signin', 'AuthController@login');

    $router->get('/questions', 'QuestionController@index');
    $router->post('/questions', 'QuestionController@save');


    $router->get('/categories', 'CategoryController@index');
    $router->post('/categories', 'CategoryController@save');


    $router->get('/sections', 'SectionController@index');
});
$router->run();

