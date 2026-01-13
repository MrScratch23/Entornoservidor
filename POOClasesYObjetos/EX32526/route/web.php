<?php

use RubenMolinaExamen\Lib\Route;
use RubenMolinaExamen\App\controllers\HomeController;
use RubenMolinaExamen\App\controllers\LoginController;

Route::get('/', [HomeController::class, 'login']);
Route::get('/principal', [HomeController::class, 'index']);
Route::get('/alta', [HomeController::class, 'alta']);

Route::post('/login/{usuario}/{password}', function($usuario, $password) {
    return LoginController::autenticarUsuario($usuario, $password);
});

Route::handleRoute();
?>