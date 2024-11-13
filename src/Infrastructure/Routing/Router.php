<?php 

    namespace App\Infrastructure\Routing;

    class Router{
        private array $routes=[];

        function addRoute(string $method,
            string $path,
            callable $action){
            $this->routes[$method][$path]=$action;
            return $this;

        }

        function dispatch(string $method,string $path){
            if(isset($this->routes[$method][$path])){       
                call_user_func($this->routes[$method][$path]);
            }else{
                http_response_code(404);
                echo "Route not found";
            }
        }
        function run(){
            $method=$_SERVER['REQUEST_METHOD'];
            $path=$_SERVER['REQUEST_URI']['PATH'];
            $this->dispatch($method,$path);
        }
    }