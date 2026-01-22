<?php

namespace RubenMolinaExamenMVC\App\controllers;
use RubenMolinaExamenMVC\App\models\LogisticaModel;
use RubenMolinaExamenMVC\Lib\SessionManager;

class LogisticaController extends Controller {

public static function index() {
    SessionManager::iniciarSesion();
    
    $mensaje = "";
    if (!isset($_SESSION['usuario'])) {
        header("Location: " . BASE_URL . "login");
        exit;
    }
    
    $usuario = SessionManager::estaAutentificado($_SESSION['usuario']);
    if (!$usuario) {
        header("Location: " . BASE_URL . "login");
        exit;
    }

    if (isset($_SESSION['mensaje-flash'])) {
        $mensaje = $_SESSION['mensaje-flash'];
        unset($_SESSION['mensaje-flash']);
    }


    
    
    $model = new LogisticaModel();
    $vehiculos = $model->obtenerTodos();
   

    self::mostrarVista("index_view", ['vehiculos' => $vehiculos, 'mensaje' => $mensaje]);

    // self::mostrarVista('index_view', $datos);
}

public static function mostrarCarga() {

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
      $paquetes = $model->obtenerPaquetes();
    $_SESSION['paquetesPendientes'] = $paquetes;


    self::mostrarVista("carga_view", ['paquetes' => $paquetes]);


}
    
public static function mostrarCargaVehiculo($id) {

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
    
    
    $id = intval($id);

    if ($id === '') {
        $_SESSION['mensaje-flash'] = "La id no puede estar vacia";
        header("Location: " . BASE_URL);
    }
   


    $model = new LogisticaModel();
    $vehiculo = $model->obtenerPorID($id);
    $_SESSION['id_vehiculo'] = $vehiculo[0]['id'];
    $paquetes = $model->obtenerPaquetes();
    $_SESSION['paquetesPendientes'] = $paquetes;


    self::mostrarVista("carga_view", ['vehiculo' => $vehiculo, 'paquetes' => $paquetes]);

}

public static function calcularCarga() {

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
    $vehiculo = $model->obtenerPorID($_SESSION['id_vehiculo']);
    $paquetes = $_SESSION['paquetesPendientes'];

    $cargaMaxima = $vehiculo['carga_maxima'];
    $volumen = $vehiculo['volumen_maximo'];
    $paquetesAceptados = [];
   
    foreach ($paquetes as $paquete) {
        if ($paquete['peso'] < $cargaMaxima && $paquete['volumen'] < $volumen) {
            $cargaMaxima.= $paquete['peso'];
            $volumen .= $paquete['volumen'];
            array_push($paquetesAceptados, $paquete);
        }
       
    }


    self::mostrarVista("carga_view", ['cargaMaxima' => $cargaMaxima, 'volumen' => $volumen, 'paquetesAceptados' => $paquetesAceptados]);


}

public static function actualizarBase() {



}

   


}

?>