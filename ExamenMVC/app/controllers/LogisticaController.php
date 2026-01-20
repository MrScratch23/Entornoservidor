<?php

namespace RubenMolinaExamenMVC\App\controllers;
use RubenMolinaExamenMVC\App\models\LogisticaModel;
use RubenMolinaExamenMVC\Lib\SessionManager;

class LogisticaController extends Controller {

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
    
    
    $model = new LogisticaModel();
    $vehiculos = $model->obtenerTodos();

    self::mostrarVista("index_view", ['vehiculos' => $vehiculos]);

    // self::mostrarVista('index_view', $datos);
}
    

   


}

?>