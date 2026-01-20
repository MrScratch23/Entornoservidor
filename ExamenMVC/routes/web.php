<?php

use RubenMolinaExamenMVC\App\controllers\LoginController;
use RubenMolinaExamenMVC\App\controllers\LogisticaController;
use RubenMolinaExamenMVC\Lib\Route;

// ruta principal
Route::get('/', [LogisticaController::class, 'index']);

// logins

Route::get('/login', [LoginController::class, 'mostrarFormularioLogin']);
Route::post('/login', [LoginController::class, 'autenticarUsuario']);
Route::get('/logout', [LoginController::class, 'cerrarSesion']);

Route::handleRoute();
?>