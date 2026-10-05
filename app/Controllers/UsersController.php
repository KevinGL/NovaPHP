<?php

namespace App\Controllers;

use Src\Controllers\AbstractController;
use App\Models\User;
use DateTimeImmutable;
use DateTimeZone;

class UsersController extends AbstractController
{
    public function index()
    {
        /*$user = $this->find(User::class, 1);
        var_dump($user);*/

        $users = $this->findAll(User::class);
        $usersArray = $this->convertArrayObject(User::class, $users);

        $this->render('Users/index.prism.php', ['users' => $usersArray]);
    }

    public function add()
    {
        $method = $this->getMethod();

        if($method === "GET")
        {
            $this->render("Users/add.prism.php");
        }

        else
        if($method === "POST")
        {
            $user = new User;

            $user->setUsername($this->varpost("name"));
            $user->setEmail($this->varpost("email"));
            $user->setPassword(password_hash($this->varpost("password"), PASSWORD_BCRYPT));
            $user->setDescription($this->varpost("description"));
            
            $now = new DateTimeImmutable();
            $now = $now->setTimezone(new DateTimeZone("Europe/Paris"));
            
            $user->setCreatedAt($now);

            if($this->insert(User::class, $user))
            {
                $this->redirectTo("/users");
            }
        }
    }
}