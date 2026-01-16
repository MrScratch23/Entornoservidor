<?php

namespace RubenMolinaExamen\App\models;

use RubenMolinaExamen\Lib\Database;

class IncidenciaModel {
    private $db;

    public function __construct() {
        $this->db = new Database ();
    }

    public function obtenerTodos() {
        $sql = "SELECT * FROM incidencias";
        $resultado = $this->db->executeQuery($sql);

        if (empty($resultado)) {
            return false;
        }

        return $resultado;
    }

    public function modificarTicket(int $id, string $asunto, string $tipo, string $estado, int $horas) {
        $sql = "UPDATE incidencias 
                SET asunto = ?, tipo_incidencia = ?, estado = ?, horas_estimadas = ?
                WHERE id = ?";

        $params = [$asunto, $tipo, $estado, $horas, $id];

        return $this->db->executeUpdate($sql, $params);
    }

    public function eliminarPorID($id) {
        $sql = "DELETE FROM incidencias WHERE id = ?";
        return $this->db->executeUpdate($sql, [$id]);
    }

    public function obtenerPorID($id) {
        $sql = "SELECT * FROM incidencias WHERE id = ?";
        return $this->db->executeQuery($sql, [$id]);
    }

    public function crear ($asunto, $tipoIncidencia, $horas) {
        $sql = "INSERT INTO incidencias(asunto, tipo_incidencia, horas_estimadas, estado, fecha_creacion) VALUES(?,?,?, 'Pendiente', NOW())";
        return $this->db->executeUpdate($sql, [$asunto, $tipoIncidencia, $horas]);
    }

    public function cambiarEstado($id, $estado) {
        $sql = "UPDATE incidencias SET estado = ? WHERE id = ?";

        if ($estado === "Pendiente") {
            $comando = "En curso";
        } elseif ($estado === "En curso") {
            $comando = "Resuelta";
        } elseif ($estado === "Resuelta") {
            $comando = "Pendiente";
        } else {
            $comando = $estado;
        }

        return $this->db->executeUpdate($sql, [$comando, $id]);
    }

    public function obtenerMediaHoras() {
        $sql = "SELECT AVG(horas_estimadas) AS media_horas FROM incidencias";
        $resultado = $this->db->executeQuery($sql);

        if (empty($resultado)) {
            return false;
        }

        return $resultado[0]['media_horas'];
    }
}
?>