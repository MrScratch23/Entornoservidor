<?php
use RubenMolinaExamen\Lib\Route;
use RubenMolinaExamen\App\Controllers\HomeController;
use RubenMolinaExamen\App\Controllers\IncidenciaController;
use RubenMolinaExamen\App\Controllers\LoginController;


Route::get('/', [LoginController::class, 'mostrarFormularioLogin'] );
Route::get('/login', [LoginController::class, 'mostrarFormularioLogin']);


Route::post('/login', [LoginController::class, 'autenticarUsuario']);
Route::get('/logout', [LoginController::class, 'cerrarSesion']);

Route::get('/principal', [HomeController::class, 'index']);
Route::get('/alta', [IncidenciaController::class, 'mostrarFormularioAlta']);




Route::handleRoute();
?>