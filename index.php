<?php

require __DIR__ . '/vendor/autoload.php';

use SekiXu\SampleRouter\Application\Library\Config;
use SekiXu\SampleRouter\Application\Library\DB;
use SekiXu\SampleRouter\Application\Library\JWT;
use SekiXu\SampleRouter\HelloWorld\HelloWorldController;
use SekiXu\SampleRouter\Todos\TodoController;
use SekiXu\SampleRouter\Groups\GroupController;
use SekiXu\SampleRouter\Groups\ShareController;
use SekiXu\SampleRouter\Test\TestController;
use SekiXu\SampleRouter\Users\UserController;
use SekiXu\SampleRouter\MyRouter;

function main(){
    $db = DB::connect(
        Config::get("DB_CONNECT_STRING"),
        Config::get("DB_USERNAME"),
        Config::get("DB_PASSWORD")
    );
    if ($db === false) {
        echo 'Database connection failed';
        return;
    }
    JWT::set_secret(Config::get("JWT_SECRET"));
    MyRouter::register([
        // new HelloWorldController($db),
        new TestController($db),
        new UserController($db),
        new GroupController($db),
        new ShareController($db),
        new TodoController($db),
    ]);
}

main();
