<?php

namespace App\Controllers;

use Src\Controllers\AbstractController;

class UsersController extends AbstractController
{
    public function index()
    {
        //

        $this->render('Users/index.prism.php', ['controller' => 'UsersController']);
    }
}