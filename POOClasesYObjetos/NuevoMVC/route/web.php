<?php


 

//registramos todas las rutas posibles

use RubenMolina\App\controllers\HomeController;
use RubenMolina\App\controllers\PersonalController;
use RubenMolina\Lib\Route;

Route::get("/pepe", function () {
    echo "hola PEPE";
});
Route::post("/login", function () {
    echo "hola página de login POST";
    $user = $_POST['user']??'';
});
//añadimos un controlador como función anónima.
Route::get("/inicio", [HomeController::class,'index']);

// como pasar variables
Route::get('/usuario/123', function () {
    echo "Usuario ID: 123";
});

//Route::get('/', function() {
//    echo "Página principal";
// });

Route::get('/', [HomeController::class, 'index']);


Route::get('/usuario/{id}', function($id) {
    echo "Usuario ID: $id"; // Ejemplo: /usuario/123
});

Route::get('/producto/{categoria}/{id}', function($categoria, $id) {
    echo "Producto $id en $categoria"; // Ejemplo: /producto/electronica/456
});

Route::get('/perfil/{nombre}', [HomeController::class, 'perfil']); // Con controlador
Route::get('/articulo/{id}/{slug}', [HomeController::class, 'articulo']); // Dos params

Route::get('/personal', [PersonalController::class,'index']);


Route::handleRoute()



?>