<?php

namespace Core;

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
        return $this->add('GET', $uri, $controller);
    }

    public function post($uri, $controller)
    {
        return $this->add('POST', $uri, $controller);
    }

    public function delete($uri, $controller)
    {
        return $this->add('DELETE', $uri, $controller);
    }

    public function patch($uri, $controller)
    {
        return $this->add('PATCH', $uri, $controller);
    }

    public function put($uri, $controller)
    {
        return $this->add('PUT', $uri, $controller);
    }

    public function only($key)
    {
        $this->routes[array_key_last($this->routes)]['middleware'] = $key;
        return $this;
    }

    public function route($uri, $method)
    {

        foreach ($this->routes as $route) {
            if ($this->match($route['uri'], $uri) && $route['method'] === strtoupper($method)) {
                Middleware::resolve($route['middleware']);
                $params = $this->extractParams($route['uri'], $uri);

                return $this->callController($route['controller'], $params);
            }
        }

        $this->abort();
    }

    protected function match($routeUri, $requestUri)
    {
        $routePattern = preg_replace('/\{[a-zA-Z0-9_]+\}/', '([a-zA-Z0-9_]+)', $routeUri);
        return preg_match('#^' . $routePattern . '$#', $requestUri);
    }


    protected function extractParams($routeUri, $requestUri)
    {
        $routePattern = preg_replace('/\{[a-zA-Z0-9_]+\}/', '([a-zA-Z0-9_]+)', $routeUri);
        preg_match('#^' . $routePattern . '$#', $requestUri, $matches);
        array_shift($matches); // Remove the full match
        return $matches;
    }

    protected function callController($controller, $params = [])
    {
        [$controller, $method] = explode('@', $controller);
        $controller = "Http\\Controllers\\{$controller}";

        if (class_exists($controller)) {
            $controllerInstance = new $controller;

            if (method_exists($controllerInstance, $method)) {
                return call_user_func_array([$controllerInstance, $method], $params);
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
