<?php

require __DIR__ . '/vendor/autoload.php';

use SekiXu\SampleRouter\Application\Library\Config;
use SekiXu\SampleRouter\Application\Library\DB;
use SekiXu\SampleRouter\HelloWorld\HelloWorldController;
use SekiXu\SampleRouter\Test\TestController;
use SekiXu\SampleRouter\MyRouter;

function main(){
    $db = new DB(
        Config::get("DB_CONNECT_STRING"),
        Config::get("DB_USERNAME"),
        Config::get("DB_PASSWORD")
    );
    if ($db === false) {
        echo 'Database connection failed';
        return;
    }
    MyRouter::register([
        HelloWorldController::class,
        TestController::class,
    ]);
}

main();
