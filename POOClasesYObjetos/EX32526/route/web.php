<?php


use RubenMolinaExamen\Lib\Route;

use RubenMolinaExamen\App\controllers\HomeController;
use RubenMolinaExamen\App\controllers\IncidenciaController;
use RubenMolinaExamen\App\controllers\LoginController;


Route::get('/', [LoginController::class, 'mostrarFormularioLogin'] );
Route::get('/login', [LoginController::class, 'mostrarFormularioLogin']);


Route::post('/login', [LoginController::class, 'autenticarUsuario']);
Route::get('/logout', [LoginController::class, 'cerrarSesion']);

Route::get('/principal', [HomeController::class, 'index']);
Route::get('/alta', [IncidenciaController::class, 'mostrarFormularioAlta']);
Route::post('/alta', [IncidenciaController::class, 'validarFormulario']);
Route::get('/eliminar/{id}', [IncidenciaController::class, 'borrarEntrada']);
Route::get('/actualizar/{id}', [IncidenciaController::class, 'actualizarEstado']);
Route::get('/modificar/{id}', [IncidenciaController::class, 'mostrarFormularioModificar']);


Route::handleRoute();
?>