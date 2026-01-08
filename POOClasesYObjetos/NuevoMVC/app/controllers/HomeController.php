<?php

namespace enrutador\app\controllers;
    
    class HomeController{
        //método estático
        static public function index(){
            echo "hola desde la página de home";
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
