<?php
namespace SekiXu\SampleRouter\Application\Library;

class Response {
    private $status = 200;

    public function status($status=200): Response {
        $this->$status = $status;
        return $this;
    }

    public function json($data){
        header("Content-Type: application/json");
        http_response_code($this->status);
        echo json_encode($data);
    }
}