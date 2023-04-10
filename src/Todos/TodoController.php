<?php
namespace SekiXu\SampleRouter\Todos;

use SekiXu\SampleRouter\Application\Library\Request;
use SekiXu\SampleRouter\Application\Library\Response;
use SekiXu\SampleRouter\Application\Library\Controller;

use PDO;

class TodoController extends Controller{
    public function routes(){
        return [
            [
                "method" => "GET",
                "path" => "/todos",
                "handler" => function(Request $request, Response $response){
                    $this->get_all($request, $response);
                }
            ],
            [
                "method" => "POST",
                "path" => "/todos",
                "handler" => function(Request $request, Response $response){
                    $this->create($request, $response);
                }
            ],
            [
                "method" => "PATCH",
                "path" => "/todos/{id}/complete/{completed}",
                "handler" => function(Request $request, Response $response){
                    $this->update($request, $response);
                }
            ],
            [
                "method" => "DELETE",
                "path" => "/todos/{id}",
                "handler" => function(Request $request, Response $response){
                    $this->delete($request, $response);
                }
            ],
        ];
    }

    public function get_all(Request $request, Response $response){
        $query = $this->db->query("SELECT * FROM todos");
        $todos = $query->fetchAll();
        $response->json([
            "data" => $users,
        ]);
    }

    public function get(Request $request, Response $response){
        $id = $request->params["id"];
        $query = $this->db->prepare("SELECT * FROM todos WHERE id = :id");
        if($query->execute(["id" => $id]) == false){
            $response->json([
                "error" => "get todo failed",
            ]);
            return;
        }
        $todo = $query->fetchAll();
        $response->json([
            "data" => $todo,
        ]);
    }

    public function create(Request $request, Response $response){
        $body = $request->get_body();
        $title = $body['title'];
        $group_id = $body['group_id'];
        $create_by = $body['create_by'];
        // check user in group
        $query = $this->db->prepare("SELECT * FROM shares WHERE group_id = :group_id or user_id = :user_id"); 
        if($query->execute(["group_id" => $group_id, "user_id" => $create_by]) == false){
            $response->json([
                "error" => "get share failed",
            ]);
            return;
        }
        $shares = $query->fetchAll();
        if(count($shares) == 0){
            $response->status(404)->json([
                "error" => "user not in group or group not found",
            ]);
            return;
        }
        // create todo
        $query = $this->db->prepare("INSERT INTO todos (title, group_id, create_by) VALUES (:title, :group_id, :create_by)");
        if($query->execute(["title" => $title, "group_id" => $group_id, "create_by"=> $create_by]) == false){
            $response->json([
                "error" => "create todo failed",
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
        $params = $request->get_params();
        $id = $params['id'];
        $completed = $params["completed"] == "1"?1:0; // 0 or 1
        $query = $this->db->prepare("UPDATE todos SET completed = :completed WHERE id = :id");
        if($query->execute(["id" => $id, "completed" => $completed]) == false){
            $response->json([
                "error" => "update todo failed",
            ]);
            return;
        }
        $response->json([
            "message" => "update todo success",
        ]);
    }

    public function delete(Request $request, Response $response){
        $params = $request->get_params();
        $id = $params['id'];
        $query = $this->db->prepare("DELETE FROM todos WHERE id = :id");
        if($query->execute(["id" => $id]) == false){
            $response->json([
                "error" => "delete todo failed",
            ]);
            return;
        }
        if($query->rowCount() == 0){
            $response->status(404)->json([
                "error" => "todo not found",
            ]);
            return;
        }
        $response->json([
            "message" => "delete todo success",
        ]);
    }
}