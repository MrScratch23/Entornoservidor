<?php
// models/DetallePersonajeModel.php
require_once APP_ROOT . '/includes/Database.php';

class DetallePersonajeModel {
    private $db;
    
    public function __construct() {
        $this->db = new Database();
    }
    
    public function obtenerDetallesCompletos($id_personaje) {
        $detalles = [
            'habilidades' => $this->obtenerHabilidades($id_personaje),
            'estadisticas' => $this->obtenerEstadisticas($id_personaje),
            'artefactos' => $this->obtenerArtefactos($id_personaje),
            'sinergias' => $this->obtenerSinergias($id_personaje),
            'reviews' => $this->obtenerReviews($id_personaje),
            'trazas' => $this->obtenerTrazas($id_personaje),
            'conos_luz' => $this->obtenerConosLuz($id_personaje)
        ];
        
        return $detalles;
    }
    
    public function obtenerHabilidades($id_personaje) {
        $sql = "SELECT * FROM habilidades_personaje WHERE id_personaje = ? ORDER BY 
                CASE tipo   
                    WHEN 'Básica' THEN 1
                    WHEN 'Habilidad' THEN 2
                    WHEN 'Definitiva' THEN 3
                    WHEN 'Talento' THEN 4
                    WHEN 'Técnica' THEN 5
                    ELSE 6
                END";
        return $this->db->executeQuery($sql, [$id_personaje]);
    }
    
    public function obtenerEstadisticas($id_personaje, $nivel = 80) {
        $sql = "SELECT * FROM estadisticas_personaje WHERE id_personaje = ? AND nivel = ?";
        $resultado = $this->db->executeQuery($sql, [$id_personaje, $nivel]);
        return $resultado[0] ?? null;
    }
    
    public function obtenerArtefactos($id_personaje) {
        $sql = "SELECT * FROM artefactos_recomendados WHERE id_personaje = ? ORDER BY 
                CASE prioridad 
                    WHEN 'Alta' THEN 1
                    WHEN 'Media' THEN 2
                    WHEN 'Baja' THEN 3
                    ELSE 4
                END,
                CASE tipo
                    WHEN 'Cuerpo' THEN 1
                    WHEN 'Pies' THEN 2
                    WHEN 'Planar' THEN 3
                    WHEN 'Manos' THEN 4
                    WHEN 'Cabeza' THEN 5
                    ELSE 6
                END";
        return $this->db->executeQuery($sql, [$id_personaje]);
    }
    
    public function obtenerSinergias($id_personaje) {
        $sql = "SELECT * FROM sinergias_personaje WHERE id_personaje = ? ORDER BY 
                CASE nivel_recomendacion 
                    WHEN 'S' THEN 1
                    WHEN 'A' THEN 2
                    WHEN 'B' THEN 3
                    WHEN 'C' THEN 4
                    ELSE 5
                END";
        return $this->db->executeQuery($sql, [$id_personaje]);
    }
    
    public function obtenerReviews($id_personaje) {
        $sql = "SELECT * FROM reviews_personaje WHERE id_personaje = ? ORDER BY fecha_publicacion DESC LIMIT 3";
        return $this->db->executeQuery($sql, [$id_personaje]);
    }
    
    public function obtenerTrazas($id_personaje) {
        $sql = "SELECT * FROM trazas_personaje WHERE id_personaje = ? ORDER BY 
                CASE tipo
                    WHEN 'Traza Ascenso' THEN 1
                    WHEN 'Traza Mayor' THEN 2
                    WHEN 'Traza Menor' THEN 3
                    ELSE 4
                END";
        return $this->db->executeQuery($sql, [$id_personaje]);
    }
    
    public function obtenerConosLuz($id_personaje) {
        $sql = "SELECT * FROM conos_luz_recomendados WHERE id_personaje = ? ORDER BY 
                CASE prioridad
                    WHEN 'Óptimo' THEN 1
                    WHEN 'Alternativa' THEN 2
                    WHEN 'Temporal' THEN 3
                    ELSE 4
                END,
                CASE rareza
                    WHEN '5 estrellas' THEN 1
                    WHEN '4 estrellas' THEN 2
                    WHEN '3 estrellas' THEN 3
                    ELSE 4
                END";
        return $this->db->executeQuery($sql, [$id_personaje]);
    }
}
?>