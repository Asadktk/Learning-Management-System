<?php

namespace Core;

use Core\Middleware\Auth;
use Core\Middleware\Guest;
use Core\Middleware\Middleware;

class Router
{

    protected $routes = [];

    public function add($method, $uri, $controller)
    {

        $this->routes[] = [
            'uri' => $uri,
            'controller' => $controller,
            'method' => $method,
            'middleware' => ''
        ];

        return $this;
    }
    public function get($uri, $controller)
    {

        return  $this->add('GET', $uri, $controller);
    }
    public function post($uri, $controller)
    {
        return  $this->add('POST', $uri, $controller);
    }
    public function delete($uri, $controller)
    {
        return  $this->add('DELETE', $uri, $controller);
    }
    public function patch($uri, $controller)
    {
        return  $this->add('PATCH', $uri, $controller);
    }
    public function put($uri, $controller)
    {
        return  $this->add('PUT', $uri, $controller);
    }

    public function only($key)
    {
        $this->routes[array_key_last($this->routes)]['middleware'] = $key;

        return $this;
    }

    public function route($uri, $method)
    {
        foreach ($this->routes as $route) {
            if ($route['uri'] === $uri && $route['method'] === strtoupper($method)) {
              
                Middleware::resolve($route['middleware']);
                
                return $this->callController($route['controller']);
                // return require base_path('Http/controllers/' . $route['controller']);
            }
        }

        $this->abort();
    }

    protected function callController($controller)
    {
        [$controller, $method] = explode('@', $controller);
        $controller = "Http\\Controllers\\{$controller}";

        if (class_exists($controller)) {
            $controllerInstance = new $controller;

            if (method_exists($controllerInstance, $method)) {
                return $controllerInstance->$method();
            }
        }

        throw new \Exception("Controller or method not found");
    }

    function abort($code = 404)
    {
        http_response_code($code);
        require base_path("views/partials/$code.php");
        die();
    }
}



// function routeToController($uri, $routes) {
//     if (array_key_exists($uri, $routes)) {
//         return require base_path($routes[$uri]);
//     } else {
//         abort();  
//     }
// }
