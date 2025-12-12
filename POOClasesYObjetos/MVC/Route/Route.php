<?php

class Route {
    // meter namespace luego
    private static array $routes =[];

   public static function get(string $uri, $callback) {
    self::$routes['GET'][$uri] = $callback;

   }

   public static function post(string $uri, $callback) {
        self::$routes['POST'][$uri] = $callback;
   }

   public static function getAll() {
    return self::$routes;
   }


}

Route::get("/", "Bienvenido a la pagina de inicio");
Route::get("/login", "Bienvenido a la pagina de login");
Route::post("/", "Bienvenido a la pagina de login - validacion de datos");
echo "<pre>";
print_r(Route::getAll());
"echo </pre>";

?>