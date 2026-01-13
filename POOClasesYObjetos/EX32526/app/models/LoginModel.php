<?php

namespace RubenMolinaExamen\App\models;
use RubenMolinaExamen\Lib\Database;

class LoginModel {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    public function autentificarUsuario($usuario, $password) {
        

     



        $sql = "SELECT id, nombre_completo, usuario, password, rol, fecha_registro FROM usuarios WHERE usuario = ?";
        


        $resultado = $this->db->executeQuery($sql, [$usuario]);
                                             
        if (empty($resultado)) {
            return false; // usuario no existe
        }
        
        $hashAlmacenado = $resultado[0]['password'];  
        
        // si la contraseña es correcta, recojo todos los datos el usuario, aunque en este examen no lo pida, me acostumbre a hacerlo por si se es admin o rol diferente
        if (password_verify($password, $hashAlmacenado)) {
            return [
                'id_usuario' => $resultado[0]['id'],
                'nombre' => $resultado[0]['nombre_completo'],
                'usuario' => $resultado[0]['usuario'],
                'rol' => $resultado[0]['rol'],
                'fecha_registro' => $resultado[0]['fecha_registro']
            ];
        }
        
        return false; // Contraseña incorrecta
    }

}