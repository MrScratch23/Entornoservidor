<?php
require_once "Database.php";

class TicketModel {
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

public function eliminarPorID($id) {
$sql = "DELETE FROM incidencias WHERE id = ?";
return $this->db->executeUpdate($sql, [$id]);
}

public function obtenerPorID($id) {
    $sql = "SELECT * FROM incidencias WHERE id = ?";
    return $this->db->executeQuery($sql, [$id]);
}

public function crear ($asunto, $tipoIncidencia, $horas) {
    // pendiente por defecto, now para la fecha actual
$sql = "INSERT INTO incidencias(asunto, tipo_incidencia, horas_estimadas, estado, fecha_creacion) VALUES(?,?,?, 'Pendiente', NOW())";
return $this->db->executeUpdate($sql, [$asunto, $tipoIncidencia, $horas]);
}

public function cambiarEstado($id, $estado) {
    
    $sql = "UPDATE  incidencias SET
     estado = ?
     WHERE id = ?";

    if ($estado === "Pendiente") {
        $comando = "En curso";
    }

    if ($estado === "En curso") {
        $comando = "Resuelta";
    }
    if ($estado === "Resuelta") {
        $comando = "Pendiente";
    }


    return $this->db->executeUpdate($sql, [$comando, $id]);
}


}





?>