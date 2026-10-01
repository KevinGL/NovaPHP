<?php

namespace App\Controllers;

use Src\Controllers\AbstractController;

class OrderController extends AbstractController
{
    public function index()
    {
        //

        $this->render('Order/index.prism.php', ['controller' => 'OrderController']);
    }
}