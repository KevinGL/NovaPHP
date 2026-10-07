<?php

namespace App\Controllers;

use Src\Controllers\AbstractController;

class HomeController extends AbstractController
{
    public function index()
    {
        //

        $this->render("Home/index.prism.php", ["name" => "Vinke013", "age" => 20, "ageMin" => 18]);
    }
}