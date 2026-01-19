<?php

namespace RubenMolinaExamen\Lib;

use mysqli;

require_once "db_credentials.php";

class Database {
    
    private $conn;
    public $error;
    
    public function __construct() {
        $this->conn = new mysqli(BD_HOST, BD_USER, BD_PASS, BD_NAME); 
        
        if ($this->conn->connect_error) {
            die("Error fatal de conexion: " . $this->conn->connect_error);
        }
        $this->conn->set_charset("utf8");
    }
    
    /**
     *funcion para detectar el tipo de parametro antes de insertar el dato
     */
    private function tipoParametro($value): string {
        if (is_int($value)) {
            return 'i'; // integer
        } elseif (is_float($value)) {
            return 'd'; // double (float)
        } elseif (is_string($value)) {
            return 's'; // string
        } elseif (is_bool($value)) {
            return 'i'; // boolean como integer (0 o 1)
        } elseif (is_null($value)) {
            return 's'; // null como string
        } else {
            return 's'; // por defecto string
        }
    }
    
    public function executeQuery($sql, $params = []) {
        $stmt = $this->conn->prepare($sql);
        
        if (!$stmt) {
            $this->error = $this->conn->error;
            return false;
        }
        
        if (!empty($params)) {
            $types = '';
            foreach ($params as $param) {
                $types .= $this->tipoParametro($param);
            }
            $stmt->bind_param($types, ...$params);
        }
        
        $stmt->execute();
        
        if ($stmt->error) {
            $this->error = $stmt->error;
            $stmt->close();
            return false;
        }
        
        $result = $stmt->get_result();
        $data = $result->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
        
        return $data;
    }
    
    public function executeUpdate($sql, $params = []) {
        $stmt = $this->conn->prepare($sql);
        
        if (!$stmt) {
            $this->error = $this->conn->error;
            return false;
        }
        
        if (!empty($params)) {
            $types = '';
            foreach ($params as $param) {
                $types .= $this->tipoParametro($param);
            }
            $stmt->bind_param($types, ...$params);
        }
        
        $success = $stmt->execute();
        
        if (!$success) {
            $this->error = $stmt->error;
            $stmt->close();
            return false;
        }
        
        $filas = $stmt->affected_rows;
        $stmt->close();
        
        return $filas;
    }
    
    public function close() {
        $this->conn->close();
    }
    
    public function getLastInsertId() {
        return $this->conn->insert_id;
    }
}
?>