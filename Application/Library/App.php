<?php

namespace SekiXu\SampleRouter\Application\Library;

use SekiXu\SampleRouter\Application\Library\Config;
use SekiXu\SampleRouter\HelloWorld\HelloWorldController;
use SekiXu\SampleRouter\MyRouter;

class App {
    
    public static function run(){
        MyRouter::register([
            HelloWorldController::class
        ]);
        // echo "Run server at " . Config::get("HOST") . ":" . Config::get("PORT") . "\n";
    }

}
