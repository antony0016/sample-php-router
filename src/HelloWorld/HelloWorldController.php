<?php
namespace SekiXu\SampleRouter\HelloWorld;

use SekiXu\SampleRouter\Application\Library\Request;
use SekiXu\SampleRouter\Application\Library\Response;

class HelloWorldController {

    public static function routes(){
        return [
            [
                "method" => "GET",
                "path" => "/helloworld",
                "handler" => function(Request $request, Response $response){
                    self::hello($request, $response);
                }
            ]
        ];
    }

    public static function hello(Request $request, Response $res){
        $res->json([
            "data" => [
                "hello" => "world"
            ]
        ]);
    }
}

