<?php

namespace Routes;

use Bramus\Router\Router as MainRouter;
use Exception;
use Illuminate\Support\Facades\Request;

class Router
{

    private MainRouter $router;

    public function __construct()
    {
        $this->router = new MainRouter;
    }

    // public function setNamespace(string $namepace)
    // {
    //     $this->router->setNamespace($namepace);
    // }

    public function get(string $route,  array $controller, string $request = "")
    {
        $this->runRequestRules($request);
        $this->router->get($route, $this->getActionController($controller));
    }

    public function post(string $route,  array $controller, string $request = "")
    {
        $this->runRequestRules($request);
        $this->router->post($route, $this->getActionController($controller));
    }

    public function mount(string $route, callable $fn)
    {
        $this->router->mount($route,  $fn);
    }

    public function run()
    {
        $this->router->run();
    }

    private function runRequestRules(string $request)
    {
        if(strlen($request) === 0) return;
        if (!class_exists($request)) {
            throw new Exception('Class not found - Try to check path');
        }
        $request = new $request;
        $request->rules();
    }

    private function getActionController(array $controller)
    {
        $methods = get_class_methods($controller[0]);
        if (!in_array($controller[1], $methods)) return new Exception('Class or method not found');
        return $controller[0] . '@' . $controller[1];
    }
}
