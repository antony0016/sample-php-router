<?php
namespace SekiXu\SampleRouter\Groups;

use SekiXu\SampleRouter\Application\Library\Request;
use SekiXu\SampleRouter\Application\Library\Response;
use SekiXu\SampleRouter\Application\Library\Controller;
use PDO;

class ShareController extends Controller{
    
    public function routes(){
        return [
            // [
            //     "method" => "GET",
            //     "path" => "/groups/shares",
            //     "handler" => function(Request $request, Response $response){
            //         $this->list($request, $response);
            //     }
            // ],
            [
                "method" => "GET",
                "path" => "/groups/shares/{group_id}",
                "handler" => function(Request $request, Response $response){
                    $this->get($request, $response);
                }
            ],
            [
                "method" => "POST",
                "path" => "/groups/shares",
                "handler" => function(Request $request, Response $response){
                    $this->create($request, $response);
                }
            ],
            [
                "method" => "DELETE",
                "path" => "/groups/shares/{id}",
                "handler" => function(Request $request, Response $response){
                    $this->delete($request, $response);
                }
            ],
        ];
    }

    // public function get_all(Request $request, Response $response){
    //     if($this->pre_verify($request, $response) == false)return;
    //     $query = $this->db->query("SELECT * FROM shares");
    //     $groups = $query->fetchAll();
    //     $response->json([
    //         "data" => $groups,
    //     ]);
    // }

    public function get(Request $request, Response $response){
        if($this->pre_verify($request, $response) == false)return;
        $params = $request->get_params();
        $group_id = $params['group_id'];
        $query = $this->db->prepare(
            "SELECT shares.id, shares.user_id, shares.group_id, users.username FROM shares left join users on users.id = shares.user_id WHERE group_id = :group_id"
        );
        if($query->execute(["group_id" => $group_id]) == false){
            $response->status(500)->json([
                "error" => "get shares failed",
            ]);
            return;
        }
        $shares = $query->fetchAll();
        $response->json([
            "data" => $shares,
        ]);
    }

    public function create(Request $request, Response $response){
        if($this->pre_verify($request, $response) == false)return;
        $body = $request->get_body();
        $group_id = $body['group_id'];
        $user_id = $body['user_id'];
        // check share exist
        $query = $this->db->prepare("SELECT * FROM shares WHERE group_id = :group_id AND user_id = :user_id");
        if($query->execute(["group_id" => $group_id, "user_id" => $user_id]) == false){
            $response->status(500)->json([
                "error" => "check share exist failed",
            ]);
            return;
        }
        $share = $query->fetchAll();
        if(count($share) > 0){
            $response->status(500)->json([
                "error" => "share already exist",
            ]);
            return;
        }
        // create group share
        $query = $this->db->prepare("INSERT INTO shares (group_id, user_id) VALUES (:group_id, :user_id)");
        if($query->execute(["group_id" => $group_id, "user_id" => $user_id]) == false){
            $response->status(500)->json([
                "error" => "create group share failed",
            ]);
            return;
        }
        $response->json([
            "data" => [
                "id" => $this->db->lastInsertId(),
            ]
        ]);
    }

    public function delete(Request $request, Response $response){
        if($this->pre_verify($request, $response) == false)return;
        $params = $request->get_params();
        $id = $params['id'];
        $query = $this->db->prepare("DELETE FROM shares WHERE id = :id");
        if($query->execute(["id" => $id]) == false){
            $response->status(500)->json([
                "error" => "delete group failed",
            ]);
            return;
        }
        if($query->rowCount() === 0){
            $response->status(404)->json([
                "error" => "group share no found",
            ]);
            return;
        }
        $response->json([
            "message" => "delete group share success",
        ]);
    }
}