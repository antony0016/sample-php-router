<?php
namespace SekiXu\SampleRouter\Users;

use SekiXu\SampleRouter\Application\Library\Request;
use SekiXu\SampleRouter\Application\Library\Response;
use SekiXu\SampleRouter\Application\Library\JWT;

use PDO;

class UserController{

    private PDO $db;

    public function __construct(PDO &$db){
        $this->db =& $db;
    }

    public function routes(){
        return [
            [
                "method" => "GET",
                "path" => "/users",
                "handler" => function(Request $request, Response $response){
                    $this->get_all($request, $response);
                }
            ],
            [
                "method" => "POST",
                "path" => "/users/register",
                "handler" => function(Request $request, Response $response){
                    $this->register($request, $response);
                }
            ],
            [
                "method" => "POST",
                "path" => "/users/login",
                "handler" => function(Request $request, Response $response){
                    $this->login($request, $response);
                }
            ],
            [
                "method" => "POST",
                "path" => "/users/verify",
                "handler" => function(Request $request, Response $response){
                    $this->verify($request, $response);
                }
            ],
        ];
    }

    public function get_all(Request $request, Response $response){
        $query = $this->db->query("SELECT username FROM users");
        $users = $query->fetchAll();
        $response->json([
            "data" => $users,
        ]);
    }

    public function register(Request $request, Response $response){
        $params = $request->get_params();
        $user = [
            "username" => $params["username"],
            "password" => password_hash($params["password"], PASSWORD_BCRYPT),
        ];
        $query = $this->db->prepare("INSERT INTO users (username, password) VALUES (:username, :password)");
        if($query->execute($user)){
            $response->json([
                "message" => "User registered",
            ]);
        } else {
            $response->status(500)->json([
                "error" => "Failed to register user",
            ]);
        }
    }

    public function login(Request $request, Response $response){
        $body = $request->get_body();
        $user = [
            "username" => $body["username"],
        ];
        $query = $this->db->prepare("SELECT * FROM users WHERE username = :username");
        $query->execute($user);
        $user = $query->fetch();
        if($user === false){
            $response->status(404)->json([
                "error" => "User not found",
            ]);
        } else {
            if(password_verify($body["password"], $user["password"])){
                $response->json([
                    "token" => JWT::sign([
                        "username" => $user["username"],
                    ]),
                ]);
            } else {
                $response->status(401)->json([
                    "error" => "Invalid password",
                ]);
            }
        }
    }

    public function verify(Request $request, Response $response){
        $body = $request->get_body();
        if(JWT::verify($body["token"])){
            $response->json([
                "message" => "Token is valid",
            ]);
        } else {
            $response->status(401)->json([
                "error" => "Token is invalid",
            ]);
        }
    }
}