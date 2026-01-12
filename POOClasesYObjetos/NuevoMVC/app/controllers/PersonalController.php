<?php


namespace RubenMolina\App\controllers;
use RubenMolina\App\controllers\Controller;
use RubenMolina\App\models\PersonalModel;

class PersonalController extends Controller {
    
       static public function index(){
           // traer los datos de PersonalModel
           $pm = new PersonalModel();
           $datos = $pm->obtenerTodos();
           
            self::mostrarTabla("index_view", ['datos' => $datos]);
        }


}

?>