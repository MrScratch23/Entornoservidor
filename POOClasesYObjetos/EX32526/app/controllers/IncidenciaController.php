<?php

namespace RubenMolinaExamen\App\controllers;

use RubenMolinaExamen\App\models\IncidenciaModel;

class IncidenciaController extends Controller {

       public static function mostrarFormularioAlta() {
     
        $errores = [];
        self::mostrarVista('alta_view', ['errores' => $errores]);
    }

}


?>