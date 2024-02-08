<?php

use Bramus\Router\Router;

use function App\infrastructure\routes\MainRouter\{
    categoryRouter,
    sectionRouter,
    domainRouter,
    qualificationRouter,
    questionRouter,
    dimensionRouter,
    surveyRoutes,
    authenticationRoutes,
};

$router = new Router();

$router->setNamespace('App\infrastructure\Controllers');

function sendCorsHeaders()
{
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json; charset=utf-8');
    header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept, session");
    header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, PATCH');
    header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
    header("Cache-Control: post-check=0, pre-check=0", "false");
    header("Pragma: no-cache");
}

$router->options('/api/.*', function () {
    sendCorsHeaders();
});

$router->mount('/api.*', function () use ($router) {

    $router->mount('/auth', function () use ($router) {
        authenticationRoutes($router);
    });

    $router->mount('/surveys', function () use ($router) {
        surveyRoutes($router);
    });

    $router->mount('/categories', function () use ($router) {
        categoryRouter($router);
    });

    $router->mount('/sections', function () use ($router) {
        sectionRouter($router);
    });

    $router->mount('/domains', function () use ($router) {
        domainRouter($router);
    });

    $router->mount('/qualifications', function () use ($router) {
        qualificationRouter($router);
    });

    $router->mount('/dimensions', function () use ($router) {
        dimensionRouter($router);
    });

    $router->mount('/questions', function () use ($router) {
        questionRouter($router);
    });
});


$router->run();
