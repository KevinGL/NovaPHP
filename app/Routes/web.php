<?php

use App\Controllers\HomeController;
use App\Controllers\UsersController;
use App\Controllers\OrderController;

$router
->add("/home", [HomeController::class, "index"])
->add("/users", [UsersController::class, "index"])
->add("/users/add", [UsersController::class, "add"])
->add("/orders", [OrderController::class, "index"])
;
