<?php

namespace App\Controllers;

use Src\Controllers\AbstractController;

class HomeController extends AbstractController
{
    public function index()
    {
        //

        $this->prism("Home/index.prism.php", ["name" => "Vinke013"]);
    }
}