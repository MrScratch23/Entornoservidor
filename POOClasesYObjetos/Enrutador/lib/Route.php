<?php

namespace Enrutador\lib;

class Route {
    // meter namespace luego
    private static array $routes =[];

   public static function get(string $uri, callable $callback) {
    self::$routes['GET'][$uri] = $callback;

   }

   public static function post(string $uri, callable $callback) {
        self::$routes['POST'][$uri] = $callback;
   }

   public static function getAll() {
    return self::$routes;
   }


   

   public static function handleRoute() {
    // comprobar en mi array si existe un elemento con ese metodo y esa uri
    $method = $_SERVER['REQUEST_METHOD'] ?? 'GET';
    $uri_full = $_SERVER['REQUEST_URI'] ?? '/';


   $script_name = $_SERVER['SCRIPT_NAME']; // ej: /proyecto/index.php 
    $uri = $_SERVER['REQUEST_URI'];
  //limpiamos la ruta (quitamos index.php)
  $base_ruta = str_replace('index.php', '', $script_name);
  // Quitamos la carpeta base de la URI para quedarnos solo con la ruta
        // Si base es '/', esto evita dobles barras
        if ($base_ruta !== '/') {
            $ruta = str_replace($base_ruta, '/', $uri);  
        } else {
            $ruta = $uri;
        }
        // Limpieza extra: Quitamos parámetros GET (?id=1...) si los hubiera
        $ruta = parse_url($ruta, PHP_URL_PATH); //esto quita todos los parámetros
        
        // Aseguramos que la ruta empiece por /
        $ruta = '/' . ltrim($ruta, '/');



        
      if (isset(self:: $routes[$method][$uri_full])) {
        call_user_func(self:: $routes[$method][$uri_full]);
    } else {
        echo "La ruta no existe-> cacho 404 error";
    }


   }


}






?>