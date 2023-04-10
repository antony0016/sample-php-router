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
        if($_SERVER["REQUEST_METHOD"] != "POST" && $_SERVER["REQUEST_METHOD"] != "PATCH"){
            return [];
        }
        $raw_data = file_get_contents("php://input");
        return json_decode($raw_data, true);
    }

    public function get_header(string $key):string {
        $key = strtoupper($key);
        $key = str_replace("-", "_", $key);
        if(isset($_SERVER["HTTP_{$key}"])){
            return $_SERVER["HTTP_{$key}"];
        }
        return "";
    }
}
