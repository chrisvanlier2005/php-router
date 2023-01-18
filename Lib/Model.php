<?php
require_once __DIR__ . "/Database.php";
class Model extends Database {
    protected $table = '';
    protected $query = '';
    protected $params = [];
    protected $modelInstance = null;
    public function find($id){
        $this->query = "SELECT * FROM $this->table WHERE id = :id";
        $this->params = [
            "id" => $id
        ];
        return $this->query($this->query, $this->params);
    }

    public static function instance(){
        $model = new self();
        return $model;
    }
}