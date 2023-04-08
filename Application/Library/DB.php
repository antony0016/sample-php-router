<?php
namespace SekiXu\SampleRouter\Application\Library;
use PDO;

class DB{
    private $instance;
    private $connected;

    function __construct($db_connect_string, $username, $password){
        $this->connected = false;
        return $this->connect($db_connect_string, $username, $password);
    }

    function connect($db_connect_string, $username, $password):false|PDO{
        // phpinfo();
        try {
            $options = [
                PDO::ATTR_EMULATE_PREPARES   => false, // Disable emulation mode for "real" prepared statements
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION, // Disable errors in the form of exceptions
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, // Make the default fetch be an associative array
              ];
            $this->instance = new PDO($db_connect_string, $username, $password, $options);
        } catch (PDOException $e) {
            // echo $e->getMessage();
            return false;
        }
        $this->connected = true;
        return $this->instance;
    }

    function is_connected(){
        return $this->connected;
    }

    function disconnect(){
        $this->connected = false;
        unset($this->instance);
    }

    function get_instance(){
        return $this->instance;
    }

    function __destruct(){
        $this->disconnect();
    }
}