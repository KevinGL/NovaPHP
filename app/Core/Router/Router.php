<?php

namespace App\Core\Router;

class Router
{
    private $routes = [];

    public function __construct()
    {
        //
    }

    public function add(string $url, array $params)
    {
        $this->routes[$url] = ["controller" => $params[0], "function" => $params[1]];
    }

    public function getRoutes(): array
    {
        return $this->routes;
    }
}