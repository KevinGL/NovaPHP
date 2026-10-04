<?php

namespace App\Controllers;

use Src\Controllers\AbstractController;
use App\Models\User;

class UsersController extends AbstractController
{
    public function index()
    {
        /*$user = $this->find(User::class, 1);
        var_dump($user);*/

        $users = $this->findAll(User::class);
        var_dump($users);

        $this->render('Users/index.prism.php', ['controller' => 'UsersController']);
    }
}