<?php
namespace SekiXu\SampleRouter\Application\Library;

class DB{
    public $instance

    function __construct(){
        $this->$instance = new PDO("mysql:host=localhost;dbname=sample_router", "root", "root");
    }
}