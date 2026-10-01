<?php

use App\Controllers\HomeController;
use App\Controllers\UsersController;
use App\Controllers\OrderController;

$router
->add("/home", [HomeController::class, "index"])
->add("/users", [UsersController::class, "index"])
->add("/orders", [OrderController::class, "index"])
;
