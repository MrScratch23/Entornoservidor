<?php

namespace RubenMolinaExamenMVC\App\controllers;
use RubenMolinaExamenMVC\Lib\SessionManager;


class Controller {

    // Método común para cargar vistas
    protected static function mostrarVista(string $vista, array $datos = []) {

        SessionManager::iniciarSesion();   
        
        // Convertimos el array en variables
        extract($datos);
      

        // Cargamos la vista
        require_once "../app/views/$vista.php";
    }


}


?>