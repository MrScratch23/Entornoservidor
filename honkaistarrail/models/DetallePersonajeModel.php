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
            'artefactos' => $this->obtenerArtefactosConImagenes($id_personaje),  // CAMBIADO
            'sinergias' => $this->obtenerSinergias($id_personaje),
            'reviews' => $this->obtenerReviews($id_personaje),
            'trazas' => $this->obtenerTrazas($id_personaje),
            'conos_luz' => $this->obtenerConosLuzConImagenes($id_personaje)    // CAMBIADO
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
    
    // MÉTODO NUEVO: Artefactos con imágenes
    public function obtenerArtefactosConImagenes($id_personaje) {
        $sql = "SELECT 
                    ar.*, 
                    a.imagen_url as imagen_artefacto
                FROM artefactos_recomendados ar 
                LEFT JOIN artefactos a ON ar.id_artefacto_maestro = a.id_artefacto 
                WHERE ar.id_personaje = ? 
                ORDER BY 
                    CASE ar.prioridad 
                        WHEN 'Alta' THEN 1
                        WHEN 'Media' THEN 2
                        WHEN 'Baja' THEN 3
                        ELSE 4
                    END,
                    CASE ar.tipo
                        WHEN 'Cuerpo' THEN 1
                        WHEN 'Pies' THEN 2
                        WHEN 'Planar' THEN 3
                        WHEN 'Manos' THEN 4
                        WHEN 'Cabeza' THEN 5
                        ELSE 6
                    END";
        return $this->db->executeQuery($sql, [$id_personaje]);
    }
    
    // MÉTODO ANTIGUO (mantener para compatibilidad)
    public function obtenerArtefactos($id_personaje) {
        return $this->obtenerArtefactosConImagenes($id_personaje);
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
    
    // MÉTODO NUEVO: Conos de luz con imágenes
    public function obtenerConosLuzConImagenes($id_personaje) {
        $sql = "SELECT 
                    clr.*, 
                    cl.imagen_url as imagen_cono
                FROM conos_luz_recomendados clr 
                LEFT JOIN conos_luz cl ON clr.id_cono_maestro = cl.id_cono 
                WHERE clr.id_personaje = ? 
                ORDER BY 
                    CASE clr.prioridad
                        WHEN 'Óptimo' THEN 1
                        WHEN 'Alternativa' THEN 2
                        WHEN 'Temporal' THEN 3
                        ELSE 4
                    END,
                    CASE clr.rareza
                        WHEN '5 estrellas' THEN 1
                        WHEN '4 estrellas' THEN 2
                        WHEN '3 estrellas' THEN 3
                        ELSE 4
                    END";
        return $this->db->executeQuery($sql, [$id_personaje]);
    }
    
    // MÉTODO ANTIGUO (mantener para compatibilidad)
    public function obtenerConosLuz($id_personaje) {
        return $this->obtenerConosLuzConImagenes($id_personaje);
    }
}
?>