<?php
namespace SekiXu\SampleRouter\Groups;

use SekiXu\SampleRouter\Application\Library\Request;
use SekiXu\SampleRouter\Application\Library\Response;
use SekiXu\SampleRouter\Application\Library\Controller;
use PDO;

class GroupController extends Controller{
    
    public function routes(){
        return [
            [
                "method" => "GET",
                "path" => "/groups",
                "handler" => function(Request $request, Response $response){
                    $this->get_all($request, $response);
                }
            ],
            [
                "method" => "GET",
                "path" => "/groups/{id}",
                "handler" => function(Request $request, Response $response){
                    $this->get($request, $response);
                }
            ],
            [
                "method" => "POST",
                "path" => "/groups",
                "handler" => function(Request $request, Response $response){
                    $this->create($request, $response);
                }
            ],
            [
                "method" => "PATCH",
                "path" => "/groups/{id}",
                "handler" => function(Request $request, Response $response){
                    $this->update($request, $response);
                }
            ],
            [
                "method" => "DELETE",
                "path" => "/groups/{id}",
                "handler" => function(Request $request, Response $response){
                    $this->delete($request, $response);
                }
            ],
        ];
    }

    public function get_all(Request $request, Response $response){
        if($this->pre_verify($request, $response) == false)return;
        $query = $this->db->query("SELECT * FROM groups");
        $groups = $query->fetchAll();
        $response->json([
            "data" => $groups,
        ]);
    }

    public function get(Request $request, Response $response){
        if($this->pre_verify($request, $response) == false)return;
        $params = $request->get_params();
        $id = $params['id'];
        $query = $this->db->prepare("SELECT * FROM groups WHERE id = :id");
        if($query->execute(["id" => $id]) == false){
            $response->status(500)->json([
                "error" => "get group failed",
            ]);
            return;
        }
        $group = $query->fetchAll();
        $response->json([
            "data" => $group,
        ]);
    }

    public function create(Request $request, Response $response){
        if($this->pre_verify($request, $response) == false)return;
        $body = $request->get_body();
        $name = $body['name'];
        $create_by = $body['create_by'];
        $query = $this->db->prepare("INSERT INTO groups (name, create_by) VALUES (:name, :create_by)");
        if($query->execute(["name" => $name, "create_by" => $create_by]) == false){
            $response->status(500)->json([
                "error" => "create group failed",
            ]);
            return;
        }
        $response->json([
            "data" => [
                "id" => $this->db->lastInsertId(),
            ],
        ]);
    }

    public function update(Request $request, Response $response){
        if($this->pre_verify($request, $response) == false)return;
        $body = $request->get_body();
        $params = $request->get_params();
        $id = $params['id'];
        $name = $body['name'];
        $query = $this->db->prepare("UPDATE groups SET name = :name WHERE id = :id");
        if($query->execute(["name" => $name, "id" => $id]) == false){
            $response->status(500)->json([
                "error" => "update group failed",
            ]);
            return;
        }
        $response->json([
            "message" => "update group success",
        ]);
    }

    public function delete(Request $request, Response $response){
        if($this->pre_verify($request, $response) == false)return;
        $params = $request->get_params();
        $id = $params['id'];
        $query = $this->db->prepare("DELETE FROM groups WHERE id = :id");
        if($query->execute(["id" => $id]) == false){
            $response->status(500)->json([
                "error" => "delete group failed",
            ]);
            return;
        }
        if($query->rowCount() === 0){
            $response->status(404)->json([
                "error" => "group no found",
            ]);
            return;
        }
        $response->json([
            "message" => "delete group success",
        ]);
    }
}