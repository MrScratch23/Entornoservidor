<?php


namespace RubenMolinaExamenMVC\App\models;

use RubenMolinaExamenMVC\Lib\Database;

class LogisticaModel {

    private $db;

    public function __construct() {
        $this->db = new Database ();
    }

    public function obtenerTodos() {
        $sql = "SELECT * FROM vehiculos";

        $resultado = $this->db->executeQuery($sql);

        if (empty($resultado)) {
            return false;
        }

        return $resultado;
    }



    }






?>