<?php

spl_autoload_register(function ($clase) {
    //Definimos el prefijo que queremos quitar (tu "Vendor")
    $prefijo = 'Enrutador\\';
    //Quitamos el prefijo de la clase (Pepelluyot\App\Coche -> App\Coche)
    // Usamos str_replace para borrar "Pepelluyot\" del principio
    $clase_relativa = str_replace($prefijo, '', $clase);
    //Cambiamos las barras invertidas por barras de directorio (App\Coche -> App/Coche)
    $ruta = "../".str_replace('\\', '/', $clase_relativa) . '.php';
    if (file_exists($ruta)) require_once $ruta;
    else die("Error: No se pudo cargar la clase $clase en la ruta $ruta");
});

use Enrutador\lib\Route;



/*echo "ENTRAMOS EN INDEXPHP A TRAVES DEL ENRUTADOR";
echo "<br>";
echo "metodo: " . $_SERVER['REQUEST_METHOD']. "<br>";
echo "uri: " . $_SERVER['REQUEST_URI'] . "<br>";
*/
// registramos todas las rutas posibles

echo Route::get("/", function () {
    echo "BUENOS DIAS VIETNAM";
});

echo Route::get("/pepe", function () {
    echo "BUENOS DIAS VIETNAM2";
});
// llamamos al metodo manejador de rutas
Route::handleRoute();



// echo Route::class;


?>