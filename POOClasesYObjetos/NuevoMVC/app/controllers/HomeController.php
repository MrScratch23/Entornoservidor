<?php

namespace RubenMolina\App\controllers;
use RubenMolina\App\controllers\Controller;

    
    class HomeController extends Controller{
        //método estático
        static public function index(){
            // echo "hola desde la página de home";
            $nombre = "Ruben";
            $apellidos = "Ternero Molina";
            // require_once "../app/views/index_view.php";

            self::mostrarVista("index_view", ['nombre'=>$nombre, 'apellidos'=>$apellidos]);
        }
        static public function show($id){
             echo "Mostramos el elemento número $id";
        }

        static function perfil($nombre) {
            echo "El nombre del perfil es: $nombre";
        }
        static function articulo($id, $slug) {
            echo "El articulo con ID: $id en $slug";
        }
    }

?>
