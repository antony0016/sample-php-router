<?php
namespace SekiXu\SampleRouter\Application\Library;

use SekiXu\SampleRouter\Application\Library\Request;
use SekiXu\SampleRouter\Application\Library\Response;
use SekiXu\SampleRouter\Application\Library\JWT;
use PDO;

abstract class Controller{
    protected PDO $db;

    public function __construct(PDO &$db){
        $this->db =& $db;
    }

    public function pre_verify(Request $request, Response $response){
        $auth = $request->get_header("authentication");
        if(strpos($auth, " ") === false){
            $response->status(401)->json([
                "error" => "Token is invalid",
            ]);
            return false;
        }else{
            $auth = explode(" ", $auth)[1];
        }
        if(!JWT::verify($auth)){
            $response->status(401)->json([
                "error" => "Token is invalid",
            ]);
            return false;
        }
        return true;
    }

    abstract public function routes();
}