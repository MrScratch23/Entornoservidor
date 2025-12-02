<?php




require_once APP_ROOT . '/includes/Database.php';



class LoginModel {

    private $db;

    public function __construct(){
        $this->db = new Database();
    }

    public function autentificarUsuario($usuario, $password) {
    $sql = "SELECT password FROM usuarios WHERE usuario = ?";
    
    
    $resultado = $this->db->executeQuery($sql, [$usuario]);
                                             
    if (empty($resultado)) {
        return false;
    }
    
    $hashAlmacenado = $resultado[0]['password'];
    return password_verify($password, $hashAlmacenado);
}

}

?>