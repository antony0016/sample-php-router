<?php

require __DIR__ . '/vendor/autoload.php';

use SekiXu\SampleRouter\Application\Library\App;
// use SekiXu\SampleRouter\Application\Library\Router;
// use SekiXu\SampleRouter\Application\Library\Request;
// use SekiXu\SampleRouter\Application\Library\Response;
// use SekiXu\SampleRouter\helloworld\HelloWorldController;



// $routes = HelloWorldController::routes();

// foreach($routes as $route){
//     switch ($route["method"]) {
//         case 'get':
//             # code...
//             break;
        
//         default:
//             # code...
//             break;
//     }
//     Router::get($route["path"], function(Request $request, Response $res) use ($route){
//         call_user_func_array([HelloWorldController::class, $route["handler"]], [$request, $res]);
//     });
// }

App::run();

