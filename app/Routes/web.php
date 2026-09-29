<?php

use App\Controllers\HomeController;

$router->add("/home", [HomeController::class, "index"]);