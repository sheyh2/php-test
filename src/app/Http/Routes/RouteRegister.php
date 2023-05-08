<?php

namespace App\Http\Routes;

/**
 * Class RouteRegister.php
 * @package App\Http\Routes
 */
class RouteRegister
{
    public function __construct(array $server)
    {
        $this->method = $server['REQUEST_METHOD'];
        $this->requestUri = $server['PATH_INFO'];
    }

    private string $requestUri;
    private string $method;
    private array $routes;

    public function get(string $url, array $routes): RouteRegister
    {
        $this->routes[$url] = [
            'action' => $routes[0],
            'action_method' => $routes[1],
            'method' => 'GET',
        ];

        return $this;
    }

    public function post(string $url, array $routes): RouteRegister
    {
        $this->routes[$url] = [
            'action' => $routes[0],
            'action_method' => $routes[1],
            'method' => 'POST',
        ];

        return $this;
    }

    public function init()
    {
        /** @var object|null $route */
        $route = $this->routes[$this->requestUri] ?? null;

        if (is_null($route)) {
            header('Content-Type: application/json; charset=utf-8');
            echo json_encode('Not found!');

            exit(404);
        }

        $action = new $route['action'];
        $actionMethod = $route['action_method'];
        if (!in_array($route['action_method'], get_class_methods($action))) {
            header('Content-Type: application/json; charset=utf-8');
            echo json_encode($route['action_method'].' method not found in '.get_class($route));

            exit(404);
        }

        if ($this->method !== $route['method']) {
            header('Content-Type: application/json; charset=utf-8');
            echo json_encode('The 405 Method Not Allowed');

            exit(405);
        }

        return $action->$actionMethod();
    }
}