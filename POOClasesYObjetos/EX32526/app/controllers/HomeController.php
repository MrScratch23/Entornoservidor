<?php

namespace RubenMolinaExamen\App\controllers;

class HomeController extends Controller {

    public static function login() {
        self::mostrarVista('login_view');
    }

    public static function index () {
     
        self::mostrarVista('index_view');

       
    }

    public static function alta () {
        self::mostrarVista('alta_view');
    }
}

?>