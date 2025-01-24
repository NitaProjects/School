<?php
session_start(); 

require __DIR__ . '/bootstrap.php';

use App\Infrastructure\Routing\Request;

$request = new Request();

$router->dispatch($request);
