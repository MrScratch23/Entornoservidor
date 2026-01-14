<?php
namespace RubenMolinaExamen\App\controllers;
use RubenMolinaExamen\App\models\IncidenciaModel;

class HomeController extends Controller {

    public static function index() {
        // primero verificar la sesion
       
        if (!isset($_SESSION['usuario'])) {
            // si no para atras
            header('Location: login');
            exit;
        }
 
        // Obtener datos del modelo
        $model = new IncidenciaModel();
        $tickets = $model->obtenerTodos();
        $mediaHoras = $model->obtenerMediaHoras();

        // datos para la vista, hay que pasarlos como array asociativo
        $datos = [
            'tickets' => $tickets, 
            'mediaHoras' => $mediaHoras,
            'usuario' => $_SESSION['usuario'] // pasar datos del usuario a la vista
        ];

        self::mostrarVista('index_view', $datos);
    }

    public static function alta() {
        // verificar sesión

        if (!isset($_SESSION['usuario'])) {
            header('Location: login');
            exit;
        }
        
        self::mostrarVista('alta_view', ['usuario' => $_SESSION['usuario']]);
    }
}
?>