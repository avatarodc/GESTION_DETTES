<?php

class Router
{
    private $routes = [
        'GET' => [],
        'POST' => []
    ];

    public function test() {
        echo "<pre>";
        print_r($this->routes);
        echo "</pre>";
    }

    public function get($uri, $action)
    {
        $this->routes['GET'][$uri] = $action;
    }

    public function post($uri, $action)
    {
        $this->routes['POST'][$uri] = $action;
    }

    public function dispatch($uri)
    {
        $method = $_SERVER['REQUEST_METHOD'];
        $uri = parse_url($uri, PHP_URL_PATH);

        
        if (isset($this->routes[$method][$uri])) {
            $this->callAction(
                ...explode('@', $this->routes[$method][$uri])
            );
        } 
        else {
            echo "404 Not Found";
        }
    }

    protected function callAction($controller, $action)
    {

        require CTL."{$controller}.php";
        $controllerInstance = new $controller;
        if (method_exists($controllerInstance, $action)) {
            $controllerInstance->$action();
        } else {
            echo "Action $action not found in controller $controller";
        }
    }
}