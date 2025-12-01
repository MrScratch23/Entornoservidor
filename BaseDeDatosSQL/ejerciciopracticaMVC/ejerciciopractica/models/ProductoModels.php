<?php

require_once APP_ROOT . '/includes/Database.php';

class ProductoModels {
    private $db;

    public function __construct(){
        $this->db = new Database();
    }

    public function crearProducto($nombre, $descripcion, $precio){
        $sql = "INSERT INTO productos (nombre, descripcion, precio, fecha_creacion) VALUES (?, ?, ?, NOW())";
        return $this->db->executeUpdate($sql, [$nombre, $descripcion, $precio]);
    }

    public function obtenerTodos() {
        $sql = "SELECT * FROM productos";
        return $this->db->executeQuery($sql);
    }

    public function eliminarProducto($id_producto) {
        $sql = "DELETE FROM productos WHERE id_producto = ?";
        return $this->db->executeUpdate($sql, [$id_producto]);
    }

    public function obtenerProductoPorId($id_producto) {
        $sql = "SELECT * FROM productos WHERE id_producto = ?";
        $resultados = $this->db->executeQuery($sql, [$id_producto]);
        return $resultados[0] ?? null;
    }

    public function actualizarProducto($id_producto, $nombre, $descripcion, $precio) {
        // ERROR: 'description' debería ser 'descripcion'
        $sql = "UPDATE productos SET nombre = ?, descripcion = ?, precio = ? WHERE id_producto = ?";
        return $this->db->executeUpdate($sql, [$nombre, $descripcion, $precio, $id_producto]);
    }
}
?>