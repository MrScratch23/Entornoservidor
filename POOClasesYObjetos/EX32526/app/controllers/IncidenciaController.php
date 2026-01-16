<?php

namespace RubenMolinaExamen\App\controllers;

use RubenMolinaExamen\App\models\IncidenciaModel;
use RubenMolinaExamen\Lib\SessionManager;

class IncidenciaController extends Controller {
    
    public static function mostrarFormularioAlta() {
    SessionManager::iniciarSesion();
    
    if (!isset($_SESSION['usuario'])) {
        header("Location: " . BASE_URL . "login");
        exit;
    }
    
    $usuario = SessionManager::estaAutentificado($_SESSION['usuario']);
    if (!$usuario) {
        header("Location: " . BASE_URL . "login");
        exit;
    }
    
    // mostrar vista, NO redirigir
    $errores = [];
    $datos = [
        'asunto' => '',
        'tipo_incidencia' => '',
        'horas_estimadas' => ''
    ];
    
    self::mostrarVista('alta_view', [
        'errores' => $errores,
        'datos' => $datos
    ]);
}


 public static function mostrarFormularioModificar($id) {
    SessionManager::iniciarSesion();
    
    if (!isset($_SESSION['usuario'])) {
        header("Location: " . BASE_URL . "login");
        exit;
    }
    
    $usuario = SessionManager::estaAutentificado($_SESSION['usuario']);
    if (!$usuario) {
        header("Location: " . BASE_URL . "login");
        exit;
    }

     if (empty($id) || !ctype_digit($id)) {
            $_SESSION['mensajeError'] = "ID inválida";
            header("Location: " . BASE_URL . "principal", true, 302);
            exit();
        }
        
        $id = intval($id);
        $model = new IncidenciaModel();
        
        $ticket = $model->obtenerPorID($id);
    
    
    
    // mostrar vista, NO redirigir
    $errores = [];
    $datos = [
        'asunto' => '',
        'tipo_incidencia' => '',
        'horas_estimadas' => ''
    ];
    
    self::mostrarVista('modificar_view', [
        'errores' => $errores,
        'datos' => $datos,
        'ticket' => $ticket
    ]);
}

public static function modificarTicket() {
    
}



    public static function validarFormulario() {
        $errores = [];
        $asunto = $_POST['asunto'] ?? '';
        $tipo_incidencia = $_POST['tipo_incidencia'] ?? '';
        $horas_estimadas = $_POST['horas_estimadas'] ?? '';
        
        // datos sticky que se enviarán a la vista
        $datosFormulario = [
            'asunto' => $asunto,
            'tipo_incidencia' => $tipo_incidencia,
            'horas_estimadas' => $horas_estimadas
        ];

       
        if ($asunto === '') {
            $errores['asunto'] = "Introduzca un asunto.";
        } 

    
        if ($tipo_incidencia === '') {
            $errores['tipo_incidencia'] = "Seleccione un tipo de incidencia.";
        } else {
            $tiposValidos = ["Hardware", "Software", "Red", "Otros"];
            if (!in_array($tipo_incidencia, $tiposValidos)) {
                $errores['tipo_incidencia'] = "Tipo de incidencia no válido.";
            }
        }

        if ($horas_estimadas === '') {
            $errores['horas_estimadas'] = "Las horas estimadas no pueden estar vacías.";
        } elseif (!is_numeric($horas_estimadas)) {
            $errores['horas_estimadas'] = "Introduzca un número válido para las horas.";
        } elseif ($horas_estimadas < 0) {
            $errores['horas_estimadas'] = "Las horas no pueden ser negativas.";
        } 
        else {
         
            $horas_estimadas = intval($horas_estimadas);
            $datosFormulario['horas_estimadas'] = $horas_estimadas;
        }

        
        if (empty($errores)) {
            $model = new IncidenciaModel();
            
        
            
            $resultado = $model->crear($asunto, $tipo_incidencia, $horas_estimadas);
            
            if ($resultado) {
                $_SESSION['mensajeExito'] = "Incidencia creada correctamente.";
                header("Location: " . BASE_URL . "principal", true, 302);
                exit;
            } else {
                $_SESSION['mensajeError'] = "Hubo un error al crear la incidencia.";
                header("Location: " . BASE_URL . "principal", true, 302);
                exit();
            }
        }

        // si hay errores, mostrar la vista con los errores y los datos del formulario
        self::mostrarVista('alta_view', [
            'errores' => $errores,
            'datos' => $datosFormulario
        ]);
    }

    public static function borrarEntrada($id) {
       

        if (empty($id) || !ctype_digit($id)) {
            $_SESSION['mensajeError'] = "ID inválida";
            header("Location: " . BASE_URL . "principal", true, 302);
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
        
        header("Location: " . BASE_URL . "principal", true, 302);
        exit();
    }

    public static function actualizarEstado($id) {
        if (empty($id) || !ctype_digit($id)) {
            $_SESSION['mensajeError'] = "ID inválida";
            header("Location: " . BASE_URL . "principal", true, 302);
            exit();
        }
        
        $id = intval($id);
        $model = new IncidenciaModel();
        $ticket = $model->obtenerPorID($id);
        
        if (empty($ticket)) {
            $_SESSION['mensajeError'] = "El ticket no existe.";
            header("Location: " . BASE_URL . "principal", true, 302);
            exit();
        }
        
        $resultado = $model->cambiarEstado($id, $ticket[0]['estado']);

        if ($resultado) {
            $_SESSION['mensajeExito'] = "Estado de ticket cambiado correctamente.";
        } else {
            $_SESSION['mensajeError'] = "No se pudo cambiar el estado del ticket.";
        }
        
        header("Location: " . BASE_URL . "principal", true, 302);
        exit();
    }
}
?>