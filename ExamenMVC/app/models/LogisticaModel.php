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

    // ejemplos con transaction y commit
// $this->db->beginTransaction();
// sql update/delete etc
// $num_registros = $this->db->executeUpdate($sql, [$nuevo_estado])
// if $num_registros != 1 $this->db-rollback
// return false
// si no hay fallo
// $this->db->commit();
// return true;
  



    }






?>