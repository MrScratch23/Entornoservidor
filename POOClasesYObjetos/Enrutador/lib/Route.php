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

      if (isset(self:: $routes[$method][$uri_full])) {
        call_user_func(self:: $routes[$method][$uri_full]);
    } else {
        echo "La ruta no existe-> cacho 404 error";
    }


   }


}



?>