<?php

namespace RubenMolinaExamen\App\controllers;

class Controller {

    // Método común para cargar vistas
    protected static function mostrarVista(string $vista, array $datos = []) {

           if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        // Convertimos el array en variables
        extract($datos);
      

        // Cargamos la vista
        require_once "../app/views/$vista.php";
    }


}


?>