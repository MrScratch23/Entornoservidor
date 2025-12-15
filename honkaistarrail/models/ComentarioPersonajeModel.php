<?php
// models/ComentarioPersonajeModel.php
require_once APP_ROOT . '/includes/Database.php';

class ComentarioPersonajeModel {
    private $db;
    
    public function __construct() {
        $this->db = new Database();
    }
    
    public function obtenerComentariosPorPersonaje($id_personaje, $limit = 20) {
        $sql = "SELECT cp.*, u.username, u.nombre as usuario_nombre 
                FROM comentarios_personaje cp 
                JOIN usuarios u ON cp.id_usuario = u.id_usuario 
                WHERE cp.id_personaje = ?
                ORDER BY cp.fecha_creacion DESC 
                LIMIT ?";
        return $this->db->executeQuery($sql, [$id_personaje, $limit]);
    }
    
    public function crearComentario($id_usuario, $id_personaje, $contenido) {
        $sql = "INSERT INTO comentarios_personaje (id_usuario, id_personaje, contenido) VALUES (?, ?, ?)";
        return $this->db->executeUpdate($sql, [$id_usuario, $id_personaje, $contenido]);
    }
    
    public function eliminarComentario($id_comentario, $id_usuario) {
        $sql = "DELETE FROM comentarios_personaje WHERE id_comentario = ? AND id_usuario = ?";
        return $this->db->executeUpdate($sql, [$id_comentario, $id_usuario]);
    }
    
    public function contarComentariosPorPersonaje($id_personaje) {
        $sql = "SELECT COUNT(*) as total FROM comentarios_personaje WHERE id_personaje = ?";
        $resultado = $this->db->executeQuery($sql, [$id_personaje]);
        return $resultado[0]['total'] ?? 0;
    }
}
?>