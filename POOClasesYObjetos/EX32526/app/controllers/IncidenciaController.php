<?php

namespace RubenMolinaExamen\App\controllers;

use RubenMolinaExamen\App\models\IncidenciaModel;

class IncidenciaController extends Controller {

        
       public static function mostrarFormularioAlta() {
     
        $errores = [];
        self::mostrarVista('alta_view', ['errores' => $errores]);
    }

    public static function validarFormuarlio() {

        $errores = [];
        $asunto = $_POST['asunto'] ?? '';
        $tipo_incidencia = $_POST['tipo_incidencia'] ?? '';
        $horas_estimadas = $_POST['horas_estimadas'] ?? '';

        if ($asunto === '') {
            $errores['asunto'] = "Introduzca un asunto.";
        }

        if ($tipo_incidencia === '') {
            $errores['tipo incidencia'] = "Introduzca una incidencia.";
        }


        /*      <option value="Hardware">Hardware</option>
                            <option value="Software">Software</option>
                            <option value="Red">Red</option>
                            <option value="Otros">Otros</option> */
        if ($tipo_incidencia != "Hardware" || $tipo_incidencia != "Software" || $tipo_incidencia != "Red" || $tipo_incidencia != "Otros") {
            # code...
        }






    }


}


?>