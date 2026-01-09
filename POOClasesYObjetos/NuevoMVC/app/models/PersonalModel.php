<?php

namespace RubenMolina\App\models;



use RubenMolina\Lib\Database;

class PersonalModel {


    private $db;

    public function __construct(){
        $this->db = new Database();
    }

       public function obtenerTodos() {
        $sql = "SELECT * FROM personal";
        return $this->db->executeQuery($sql);
    }

}



?>