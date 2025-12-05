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




    public function autentificarUsuarioEmailPassWord($email, $password) {
        // Consulta usando email en lugar de usuario
        $sql = "SELECT id, usuario, password, rol, email FROM usuarios WHERE email = ?";
        
        $resultado = $this->db->executeQuery($sql, [$email]);
                                             
        if (empty($resultado)) {
            return false; // Email no existe
        }
        
        $hashAlmacenado = $resultado[0]['password'];

        if (password_verify($password, $hashAlmacenado)) {
            return [
                'id' => $resultado[0]['id'],
                'nombre' => $resultado[0]['usuario'],
                'rol' => $resultado[0]['rol'],
                'email' => $resultado[0]['email'] 
            ];
        }
        
        return false; 
    }
}
?>



