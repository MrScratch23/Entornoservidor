<?php

namespace RubenMolinaExamenMVC\Lib;

class Route
{
    //array que almacenará las posibles rutas a la aplicación
    private static array $routes = [];

    //método para almacenar las rutas de tipo GET
    public static function get(string $uri, callable $callback){
        self::$routes['GET'][$uri] = $callback;
    }

    //método para almacenar las rutas de tipo POST
    public static function post(string $uri, callable $callback){
        self::$routes['POST'][$uri] = $callback;
    }

    //método para procesar las rutas
    public static function handleRoute() {
        //recogemos la ruta
        $script_name = $_SERVER['SCRIPT_NAME'];
        //obtener la URI
        $uri = $_SERVER['REQUEST_URI'];
        //recogemos el método
        $method = $_SERVER['REQUEST_METHOD'];

        //1.- eliminar la parte del base path
        $base_ruta = str_replace('index.php', '', $script_name);
        //limpiamos la ruta y nos quedamos sólo con la parte relevante
        if ($base_ruta !== '/') {
            $ruta = str_replace($base_ruta, '/', $uri);
        } else {
            $ruta = $uri;
        }
        
        //2.- comprobar en mi array si existe un elemento con ese método y esa uri
        if (isset(self::$routes[$method][$ruta])) {
            call_user_func(self::$routes[$method][$ruta]);
            return;
        }
        
   
        $ruta_parts = explode('/', trim($ruta, '/'));

        foreach (self::$routes[$method] ?? [] as $route => $handler) {
            $route_parts = explode('/', trim($route, '/'));
            
            if (count($route_parts) === count($ruta_parts)) {
                $params = [];
                $match = true;
                
                for ($i = 0; $i < count($route_parts); $i++) { 
                    if (preg_match('/^\{(.+)\}$/', $route_parts[$i], $matches)) {
                        $params[$matches[1]] = $ruta_parts[$i];
                    } elseif ($route_parts[$i] != $ruta_parts[$i]) {
                        $match = false;
                        break;
                    }
                }

                if ($match) {
                    call_user_func_array($handler, $params);
                    return;
                }
            }
        }

        http_response_code(404);
        echo "<h1>404: Ruta no encontrada: $ruta</h1>";
    }
}
?>