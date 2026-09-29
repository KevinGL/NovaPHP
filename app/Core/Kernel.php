<?php

namespace App\Core;

use App\Core\Router\Router;

class Kernel
{
    public function boot(): void
    {
        $router = new Router();
        require_once __DIR__ . '/../Routes/web.php';
        
        $url = $_SERVER["PATH_INFO"];
        $routes = $router->getRoutes();

        if(array_key_exists($url, $routes))
        {
            $controller = new $routes[$url]["controller"];
            $controller->{$routes[$url]["function"]}(...$_GET);
        }

        else
        {
            echo "Route $url does not exist";
        }
    }
}