<?php
namespace SekiXu\SampleRouter\Application\Library;
use PDO;

class DB{
    private static $instance;

    // function __construct($db_connect_string, $username, $password){
    //     self::connected = false;
    //     // return self::connect($db_connect_string, $username, $password);
    // }

    static function connect($db_connect_string, $username, $password){
        // phpinfo();
        try {
            $options = [
                PDO::ATTR_EMULATE_PREPARES   => false, // Disable emulation mode for "real" prepared statements
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION, // Disable errors in the form of exceptions
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, // Make the default fetch be an associative array
              ];
            self::$instance = new PDO($db_connect_string, $username, $password, $options);
        } catch (PDOException $e) {
            // echo $e->getMessage();
            return false;
        }
        return self::$instance;
    }

    static function is_connected(){
        return self::$instance === null ? false : true;
    }

    static function disconnect(){
        unset(self::$instance);
    }

    static function get_instance():false|PDO{
        if (self::$connected === false){
            return false;
        }
        return self::$instance;
    }
}