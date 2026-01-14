<?php

namespace RubenMolinaExamen\App\controllers;

use RubenMolinaExamen\App\models\IncidenciaModel;

class IncidenciaController extends Controller {

        
       public static function mostrarFormularioAlta() {
     
        $errores = [];
        self::mostrarVista('alta_view', ['errores' => $errores]);
    }

    public static function validarFormulario() {

        $errores = [];
        $asunto = $_POST['asunto'] ?? '';
        $tipo_incidencia = $_POST['tipo_incidencia'] ?? '';
        $horas_estimadas = $_POST['horas_estimadas'] ?? '';

        if ($asunto === '') {
            $errores['asunto'] = "Introduzca un asunto.";
        }

        if ($tipo_incidencia === '') {
            $errores['tipo_incidencia'] = "Introduzca una incidencia.";
        }

        // validar que el tipo de incidencia es valido
        if ($tipo_incidencia != "Hardware" && $tipo_incidencia != "Software" && $tipo_incidencia != "Red" && $tipo_incidencia != "Otros") {
            $errores['tipo_incidencia'] = "Incidencia no valida";
        }

        if (!intval($horas_estimadas)) {
            $errores['horas_estimadas'] = "Introduzca una hora valida";
        }

        if ($horas_estimadas < 0) {
            $errores['horas_estimadas'] = "Introduzca un numero valido.";
        }

        if ($horas_estimadas === '') {
            $errores['horas_estimadas'] = "Las horas estimadas no pueden estar vacias";
        }

        if (empty($errores)) {
            $model = new IncidenciaModel();
           

            $resultado = $model->crear($asunto, $tipo_incidencia, $horas_estimadas);
             if ($resultado) {
            $_SESSION['mensajeExito'] = "Registro completado correctamente";
            header('Location: principal'); 
            exit;
            
        } else {    

             
             // guardar el mensaje de error en session
             $_SESSION['mensajeError'] = "Hubo un error creando el ticket.";
            header('Location: principal'); 
            exit();
            
        }

        }

        self::mostrarVista('alta_view', ['errores' => $errores]);




    }

    public static function borrarEntrada($id) {
   // id viene por parametro de la ruta
    
    
    if (empty($id) || !is_numeric($id)) {
        $_SESSION['mensajeError'] = "ID inválida";
        header('Location:principal');
        exit();
    }
    
    $id = intval($id);
    $model = new IncidenciaModel();
    
    
    $resultado = $model->eliminarPorID($id);
    
    if ($resultado) {
        $_SESSION['mensajeExito'] = "Ticket eliminado correctamente.";
    } else {
        $_SESSION['mensajeError'] = "No se pudo eliminar el ticket.";
    }
    
    header("Location: principal");
    exit();
}


}


?>