<?php
require_once APP_ROOT . '/includes/Database.php';

class LoginModel {
    private $db;

    public function __construct(){
        $this->db = new Database();
    }

    public function autentificarUsuario($username, $password) {
    
        $sql = "SELECT id_usuario, username, password_hash, nombre, rol FROM usuarios WHERE username = ?";
        
        $resultado = $this->db->executeQuery($sql, [$username]);
                                             
        if (empty($resultado)) {
            return false; // Usuario no existe
        }
        
        $hashAlmacenado = $resultado[0]['password_hash'];
        

        if (password_verify($password, $hashAlmacenado)) {
            return [
                'id' => $resultado[0]['id_usuario'],
                'username' => $resultado[0]['username'],
                'nombre' => $resultado[0]['nombre'],
                'rol' => $resultado[0]['rol']
            ];
        }
        
        return false; 
    }
}
?>