<?php
// models/LoginModel.php (corregido)
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
            return false;
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
    
    public function registrarUsuario($username, $password, $email, $nombre) {
        // Verificar si el usuario ya existe
        $sql_check = "SELECT id_usuario FROM usuarios WHERE username = ? OR email = ?";
        $existe = $this->db->executeQuery($sql_check, [$username, $email]);
        
        if (!empty($existe)) {
            return ['error' => 'El usuario o email ya existe'];
        }
        
        // Crear hash de contraseña
        $password_hash = password_hash($password, PASSWORD_DEFAULT);
        
        // Insertar nuevo usuario
        $sql = "INSERT INTO usuarios (username, password_hash, email, nombre, rol) 
                VALUES (?, ?, ?, ?, 'usuario')";
        
        $resultado = $this->db->executeUpdate($sql, [$username, $password_hash, $email, $nombre]);
        
        if ($resultado) {
            // Obtener el ID del usuario recién insertado
            $sql_last_id = "SELECT LAST_INSERT_ID() as last_id";
            $id_result = $this->db->executeQuery($sql_last_id);
            $last_id = $id_result[0]['last_id'] ?? null;
            
            return ['success' => true, 'id' => $last_id];
        }
        
        return ['error' => 'Error al registrar usuario'];
    }
    
    public function obtenerUsuarioPorId($id) {
        $sql = "SELECT id_usuario, username, email, nombre, rol FROM usuarios WHERE id_usuario = ?";
        $resultado = $this->db->executeQuery($sql, [$id]);
        return $resultado[0] ?? null;
    }
}
?>