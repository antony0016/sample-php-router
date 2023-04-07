<?php

namespace SekiXu\SampleRouter\Application\Library;

use SekiXu\SampleRouter\Application\Library\Request;
use SekiXu\SampleRouter\Application\Library\Response;


class Router {
    public static function get($route, $callback):void{
        if(strcasecmp($_SERVER["REQUEST_METHOD"], "GET") != 0){
            return;
        }

        self::on($route, $callback);
    }

    public static function post($route, $callback):void{
        if(strcasecmp($_SERVER["REQUEST_METHOD"], "POST") != 0){
            return;
        }

        self::on($route, $callback);
    }

    public static function patch($route, $callback):void{
        if(strcasecmp($_SERVER["REQUEST_METHOD"], "PATCH") != 0){
            return;
        }

        self::on($route, $callback);
    }

    public static function delete($route, $callback):void{
        if(strcasecmp($_SERVER["REQUEST_METHOD"], "PUT") != 0){
            return;
        }

        self::on($route, $callback);
    }

    public static function vaild($route, $path):bool{
        $regex = preg_replace("/\{([a-zA-Z0-9_]+)\}/", "([a-zA-Z0-9_]+)", $route);
        $regex = str_replace("/", "\/", $regex);
        return preg_match("/^" . $regex . "$/", $path);
    }

    public static function get_params(string $route, string $path):array{
        $params = [];
        $param_keys = [];
        $param_values = [];
        // param keys
        preg_match_all("/\{([a-zA-Z0-9_]+)\}/", $route, $param_keys);
        array_shift($param_keys);
        $param_keys = $param_keys[0];

        // param values
        $regex = preg_replace("/\{([a-zA-Z0-9_]+)\}/", "([a-zA-Z0-9_]+)", $route);
        // escape slash in regex
        $regex = str_replace("/", "\/", $regex);
        preg_match_all("/^" . $regex . "$/", $path, $param_values);
        // shift origin string
        array_shift($param_values);
        $param_values = $param_values[0];

        // return empty array if param_keys or param_values is not array
        if(!is_array($param_values) || !is_array($param_keys)){
            return [];
        }

        // return empty array if param_keys and param_values is not same length
        if(count($param_keys) != count($param_values)){
            return [];
        }
        
        return array_combine($param_keys, $param_values);
    }

    public static function get_queries(string $raw_query):array{
        $result = [];
        $queries = explode("&", $raw_query);
        foreach ($queries as $value) {
            $query = explode("=", $value);
            $result[$query[0]] = $query[1];
        }
        return $result;
    }

    public static function on($route, $callback):void{
        // split uri to query, path, and params
        $request_uri = $_SERVER["REQUEST_URI"];
        [$path, $query] = explode("?", $request_uri);
        // query
        $queries = [];
        if($query){
            $queries = self::get_queries($query);
        }
        // params
        $params = self::get_params($route, $path);
        
        // check if path match regex
        if(!self::vaild($route, $path)){
            // header("HTTP/1.1 404 Not Found");
            http_response_code(404);
            return;
        }
        // call callback
        $callback(new Request($params, $queries), new Response());
    }
}
