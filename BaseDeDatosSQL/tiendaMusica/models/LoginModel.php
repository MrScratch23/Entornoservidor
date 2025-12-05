<?php
require_once APP_ROOT . '/includes/Database.php';

class LoginModel {
    private $db;

    public function __construct(){
        $this->db = new Database();
    }

    public function autentificarUsuario($usuario, $password) {
      
        $sql = "SELECT id, usuario, password, rol FROM usuarios WHERE usuario = ?";
        
        $resultado = $this->db->executeQuery($sql, [$usuario]);
                                             
        if (empty($resultado)) {
            return false; // Usuario no existe
        }
        
        $hashAlmacenado = $resultado[0]['password']; // Columna 'password', no 'password_hash'

        if (password_verify($password, $hashAlmacenado)) {
            return [
                'id' => $resultado[0]['id'],           // Columna 'id'
                'nombre' => $resultado[0]['usuario'],  // Columna 'usuario'
                'rol' => $resultado[0]['rol']          // Columna 'rol'
            ];
        }
        
        return false; 
    }
}
?>