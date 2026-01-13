<?php

namespace RubenMolinaExamen\App\controllers;
use RubenMolinaExamen\App\models\IncidenciaModel;

class HomeController extends Controller {

    public static function login() {
        self::mostrarVista('login_view');
    }

public static function index () {
 
    $model = new IncidenciaModel();
    $tickets = $model->obtenerTodos();
    $mediaHoras = $model->obtenerMediaHoras();

    $datos = ['tickets' => $tickets, 'mediaHoras' => $mediaHoras];

    self::mostrarVista('index_view', $datos);

   
}

    public static function alta () {
        self::mostrarVista('alta_view');
    }
}

?>