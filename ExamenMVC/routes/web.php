<?php

/* 
// orden de rutas

REGLAS DE ORO PARA ORDENAR RUTAS
De más específica a más general (siempre)

Rutas fijas antes que rutas con parámetros

Parámetros concretos antes que parámetros genéricos
// ejemplos

// 1. Rutas FIJAS (sin parámetros)
Route::get('/articulo/crear', [ArticuloController::class, 'crear']);
Route::get('/articulo/editar', [ArticuloController::class, 'editar']);

// 2. Rutas con partes FIJAS en medio
Route::get('/articulo/{id}/comparar/{id2}', [ArticuloController::class, 'comparar']);
Route::get('/articulo/{id}/comentarios', [ArticuloController::class, 'comentarios']);

// 3. Rutas con parámetros CONCRETOS
Route::get('/articulo/{id}/{accion}', [ArticuloController::class, 'accion']);

// 4. Rutas GENÉRICAS (últimas)
Route::get('/articulo/{id}', [ArticuloController::class, 'mostrar']);
Route::get('/articulo/{id}/{slug}', [ArticuloController::class, 'mostrarConSlug']);
*/



use RubenMolinaExamenMVC\App\controllers\LoginController;
use RubenMolinaExamenMVC\App\controllers\LogisticaController;
use RubenMolinaExamenMVC\Lib\Route;

// ruta principal
Route::get('/', [LogisticaController::class, 'index']);

// logins

Route::get('/login', [LoginController::class, 'mostrarFormularioLogin']);
Route::post('/login', [LoginController::class, 'autenticarUsuario']);
Route::get('/logout', [LoginController::class, 'cerrarSesion']);
Route::get('/carga', [LogisticaController::class, 'mostrarCarga']);
Route::post('/carga/{id}', [LogisticaController::class, 'mostrarCargaVehiculo']);
Route::post('/carga', [LogisticaController::class, 'calcularCarga']);
// Route::post('/carga/confirmar')


Route::handleRoute();
?>