<?php

use RubenMolinaExamenMVC\App\controllers\LoginController;
use RubenMolinaExamenMVC\App\controllers\LogisticaController;
use RubenMolinaExamenMVC\Lib\Route;

// probar con esta
Route::get('/', function() {
    header('Location: /login');
    exit();
});




Route::get('/login', [LoginController::class, 'mostrarFormularioLogin']);
Route::post('/login', [LoginController::class, 'autenticarUsuario']);
Route::get('/principal', [LogisticaController::class, 'index']);


Route::handleRoute();
?>