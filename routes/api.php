<?php

use Bramus\Router\Router;

use function App\infrastructure\routes\questionRoutes;

$router = new Router();

// $router->setNamespace('App\infrastructure\Controllers');

function sendCorsHeaders()
{
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json; charset=utf-8');
    header('Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept, session');
    header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, PATCH');
    header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');
    header('Cache-Control: post-check=0, pre-check=0', 'false');
    header('Pragma: no-cache');
}

$router->options('/api.*', function () {
    sendCorsHeaders();
});

$router->mount('/api.*', function () use ($router) {

    // $router->get('/me', 'AuthController@me');
    // $router->post('/signin', 'AuthController@login');

    $router->get('/questions', function() {
        print_r("xd");
    });


    // $router->get('/categories', 'CategoryController@index');
    // $router->post('/categories', 'CategoryController@save');

    // $router->get('/domains', 'DomainController@index');
    // $router->post('/domains', 'DomainController@save');

    // $router->get('/dimensions', 'DimensionController@index');
    // $router->post('/dimensions', 'DimensionController@save');

    // $router->get('/sections', 'SectionController@index');


    // $router->get('/qualifications', 'QualificationOptionController@index');
});
$router->run();
