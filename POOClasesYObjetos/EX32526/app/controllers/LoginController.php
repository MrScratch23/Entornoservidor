<?php

namespace RubenMolinaExamen\App\controllers;
use RubenMolinaExamen\App\models\LoginModel;

class LoginController extends Controller {

   

public static function autenticarUsuario ($usuario, $password) {
 
    $model = new LoginModel();
    $usuario = $model->autentificarUsuario($usuario, $password);
    

  

    self::mostrarVista('login_view', $usuario);

   
}

    public static function alta () {
        self::mostrarVista('alta_view');
    }
}

?>