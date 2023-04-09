<?php

namespace SekiXu\SampleRouter\Todos\Model;

class Users{
    // private int $id;
    // private int $username;
    // private string $password;
    public int $id;
    public int $username;
    public string $password;
    

    public function __construct(int $id, int $username, string $password){
        $this->id = $id;
        $this->username = $username;
        $this->password = password_hash($password, PASSWORD_BCRYPT);
    }
}