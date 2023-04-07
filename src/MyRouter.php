<?php
namespace SekiXu\SampleRouter;

use SekiXu\SampleRouter\Application\Library\Router;
use SekiXu\SampleRouter\Application\Library\Request;
use SekiXu\SampleRouter\Application\Library\Response;
use SekiXu\SampleRouter\helloworld\HelloWorldController;

class MyRouter {
    public static function register($controllers){
        foreach($controllers as $controller){
            $routes = $controller::routes();
            foreach($routes as $route){
                switch (strtolower($route["method"])) {
                    case 'get':
                        Router::get($route["path"], $route["handler"]);
                        break;
                    case 'post':
                        Router::post($route["path"], $route["handler"]);
                        break;
                    case 'patch':
                        Router::patch($route["path"], $route["handler"]);
                        break;
                    case 'delete':
                        Router::delete($route["path"], $route["handler"]);
                        break;
                    
                }
            }
        }
    }
}

