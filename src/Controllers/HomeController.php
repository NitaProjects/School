<?php

namespace App\Controllers;

use App\Infrastructure\HTTP\Response;
use App\Infrastructure\Routing\Request;

class HomeController {
 
    public function index(Request $request): Response {
        return Response::html('home', []); 
    }
}
