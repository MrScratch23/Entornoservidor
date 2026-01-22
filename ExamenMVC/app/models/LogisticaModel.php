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

    public function obtenerPorID($id) {
        // ejemplo $sql = "SELECT * FROM incidencias WHERE id = ?";
        $sql = "SELECT * FROM vehiculos WHERE id = ?";

        $resultado = $this->db->executeQuery($sql, [$id]);

           if (empty($resultado)) {
            return false;
        }

        return $resultado;

    }
  
    public function obtenerPaquetes() {
        $sql = "SELECT * FROM paquetes
        where estado = 'Pendiente'
        ORDER BY prioridad ASC, peso DESC";

         $resultado = $this->db->executeQuery($sql);

        if (empty($resultado)) {
            return false;
        }

        return $resultado;

    }

    public function confirmarEnvio($id_vehiculo, array $codigos_paquetes) {
        $this->db->beginTransaction();

        $sqlIV = "UPDATE vehiculos SET estado = 'En ruta' WHERE id = ?";
        $update_vehiculo = $this->db->executeUpdate($sqlIV, [$id_vehiculo]);

        $placeholders = implode(',', array_fill(0, count($codigos_paquetes), '?'));

    }


    }






?>