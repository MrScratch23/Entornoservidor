<?php

namespace RubenMolinaExamenMVC\Lib;

class SessionManager {

    public static function iniciarSesion() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    public static function destruirSesion() {
        session_unset();
        session_destroy();
    }

    // comprobar si hay una sesión activa
    public static function estaAutentificado($usuario) { 

        return isset($usuario);
        

        
    }
}

?>