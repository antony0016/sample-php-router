<?php

require __DIR__ . '/vendor/autoload.php';

use SekiXu\SampleRouter\Application\Library\Config;
use SekiXu\SampleRouter\HelloWorld\HelloWorldController;
use SekiXu\SampleRouter\Test\TestController;
use SekiXu\SampleRouter\MyRouter;

function main(){
    MyRouter::register([
        HelloWorldController::class,
        TestController::class,
    ]);
}

main();
