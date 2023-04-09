<?php
namespace SekiXu\SampleRouter\Test;

use SekiXu\SampleRouter\Application\Library\Request;
use SekiXu\SampleRouter\Application\Library\Response;
use SekiXu\SampleRouter\Application\Library\DB;

class TestController {

    private $db;

    public function __construct($db){
        $this->db = $db;
    }

    public function routes(){
        return [
            [
                "method" => "GET",
                "path" => "/check",
                "handler" => function(Request $request, Response $response){
                    $this->check($request, $response);
                }
            ]
        ];
    }

    public function check(Request $request, Response $res){
        $res->json([
            "data" => [
                "params" => $request->get_params(),
                "query" => $request->get_queries(),
                "db_test" => "test",
            ]
        ]);
    }
}

