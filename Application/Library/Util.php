<?php
namespace SekiXu\SampleRouter\Application\Library;

class Util {
    public static function secure_base64_encode(string $data){
        return str_replace(["+", "/", "="], ["-", "_", ""], base64_encode($data));
    }

    public static function secure_base64_decode(string $data){
        $data .= str_repeat("=", 4 - (strlen($data) % 4));
        return base64_decode(str_replace(["-", "_"], ["+", "/"], $data));
    }
}