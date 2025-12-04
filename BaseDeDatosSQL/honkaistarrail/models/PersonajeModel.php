<?php
require_once APP_ROOT . '/includes/Database.php';

class PersonajeModel {
    private $db;
    
    public function __construct() {
        $this->db = new Database();
    }
    
    public function obtenerTodos() {
        $sql = "SELECT * FROM personajes ORDER BY 
                CASE rareza 
                    WHEN '5 estrellas' THEN 1 
                    WHEN '4 estrellas' THEN 2 
                    ELSE 3 
                END, nombre";
        return $this->db->executeQuery($sql);
    }
    
    public function obtenerPorRareza($rareza) {
        $sql = "SELECT * FROM personajes WHERE rareza = ? ORDER BY nombre";
        return $this->db->executeQuery($sql, [$rareza]);
    }
    
    public function obtenerPorRuta($ruta) {
        $sql = "SELECT * FROM personajes WHERE ruta = ? ORDER BY nombre";
        return $this->db->executeQuery($sql, [$ruta]);
    }
    
    public function obtenerPorElemento($elemento) {
        $sql = "SELECT * FROM personajes WHERE elemento = ? ORDER BY nombre";
        return $this->db->executeQuery($sql, [$elemento]);
    }
    
    public function buscar($termino) {
        $sql = "SELECT * FROM personajes 
                WHERE nombre LIKE ? OR alias LIKE ? OR descripcion LIKE ? 
                ORDER BY nombre";
        $busqueda = "%$termino%";
        return $this->db->executeQuery($sql, [$busqueda, $busqueda, $busqueda]);
    }
    
    public function obtenerPorId($id) {
        $sql = "SELECT * FROM personajes WHERE id_personaje = ?";
        $resultados = $this->db->executeQuery($sql, [$id]);
        return $resultados[0] ?? null;
    }
}
?>