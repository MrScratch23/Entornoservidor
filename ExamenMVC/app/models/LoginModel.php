<?php

namespace RubenMolinaExamenMVC\App\models;
use RubenMolinaExamenMVC\Lib\Database;

class LoginModel {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    public function autentificarUsuario($id, $pin) {
        

    
        $sql = "SELECT id_empleado, nombre, apellidos, pin, fecha_creacion FROM empleados WHERE id_empleado = ?";
        


        $resultado = $this->db->executeQuery($sql, [$id]);
                                             
        if (empty($resultado)) {
            return false; // usuario no existe
        }
        
        $hashAlmacenado = $resultado[0]['pin'];  
        
        // si la contraseña es correcta, recojo todos los datos el usuario, aunque en este examen no lo pida, me acostumbre a hacerlo por si se es admin o rol diferente
        if (password_verify($pin, $hashAlmacenado)) {
            return [
                'id_empleado' => $resultado[0]['id_empleado'],
                'nombre' => $resultado[0]['nombre'],
                'apellidos' => $resultado[0]['apellidos'],
                'pin' => $resultado[0]['pin'],
                'fecha_creacion' => $resultado[0]['fecha_creacion']
            ];
        }
        
        return false; // Contraseña incorrecta
    }

}