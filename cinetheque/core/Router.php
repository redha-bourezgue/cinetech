<?php

class Router {
    private $routes = [];
    private $middlewares = [];

    public function get($path, $callback, $middleware = null) {
        $this->addRoute('GET', $path, $callback, $middleware);
    }

    public function post($path, $callback, $middleware = null) {
        $this->addRoute('POST', $path, $callback, $middleware);
    }

    private function addRoute($method, $path, $callback, $middleware) {
        $this->routes[] = [
            'method' => $method,
            'path' => $path,
            'callback' => $callback,
            'middleware' => $middleware
        ];
    }

    public function dispatch($uri, $method) {
        foreach ($this->routes as $route) {
            if ($route['path'] === $uri && $route['method'] === $method) {
                // Vérifier le middleware
                if ($route['middleware']) {
                    $middlewareClass = new $route['middleware']();
                    $middlewareClass->handle();
                }

                // Exécuter le callback
                if (is_string($route['callback'])) {
                    list($controller, $method) = explode('@', $route['callback']);
                    $controller = new $controller();
                    return $controller->$method();
                }
                return $route['callback']();
            }
        }
        
        // Route non trouvée
        header("HTTP/1.0 404 Not Found");
        require 'views/errors/404.php';
    }
} 