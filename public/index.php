<?php

require_once __DIR__ . '/../vendor/autoload.php';

use App\Core\Kernel;

$kernel = new Kernel();
$kernel->boot();