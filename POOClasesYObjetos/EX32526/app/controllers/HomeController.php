<?php
namespace RubenMolinaExamen\App\controllers;
use RubenMolinaExamen\App\models\IncidenciaModel;
use RubenMolinaExamen\Lib\SessionManager;

class HomeController extends Controller {

  public static function index() {
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
    
    
    $model = new IncidenciaModel();
    $tickets = $model->obtenerTodos();
    $mediaHoras = $model->obtenerMediaHoras();

    $datos = [
        'tickets' => $tickets, 
        'mediaHoras' => $mediaHoras,
        'usuario' => $_SESSION['usuario']
    ];

    self::mostrarVista('index_view', $datos);
}
    

   
}
?>