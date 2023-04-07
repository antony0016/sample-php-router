<?php
namespace SekiXu\SampleRouter\Application\Library;

class Request {
    private $params = [];
    private $queries = [];

    public function __construct($params, $queries){
        $this->params = $params;
        $this->queries = $queries;
    }

    public function get_params():array {
        return $this->params;
    }

    public function get_queries():array {
        return $this->queries;
    }

    public function get_body():array {
        if($_SERVER["REQUEST_METHOD"] != "POST"){
            return [];
        }
        $raw_data = file_get_contents("php://input");
        return json_decode($raw_data, true);
    }
}
