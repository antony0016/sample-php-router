<?php

namespace SekiXu\SampleRouter\Todos\Model;

class Todos{
    // private int $id;
    // private int $group_id;
    // private string $title;
    // private bool $completed;
    // private int $create_by;
    public int $id;
    public int $group_id;
    public string $title;
    public bool $completed;
    public int $create_by;

    public function __construct(int $id, int $group_id, string $title, bool $completed, int $create_by){
        $this->id = $id;
        $this->group_id = $group_id;
        $this->title = $title;
        $this->completed = $completed;
        $this->create_by = $create_by;
    }
}