<?php
namespace SekiXu\SampleRouter\Test;

use SekiXu\SampleRouter\Application\Library\Request;
use SekiXu\SampleRouter\Application\Library\Response;

class TestController {

    public static function routes(){
        return [
            [
                "method" => "GET",
                "path" => "/check",
                "handler" => function(Request $request, Response $response){
                    self::check($request, $response);
                }
            ]
        ];
    }

    public static function check(Request $request, Response $res){
        $res->json([
            "data" => [
                "params" => $request->get_params(),
                "query" => $request->get_queries(),
            ]
        ]);
    }
}

