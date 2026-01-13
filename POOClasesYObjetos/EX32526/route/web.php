<?php

use RubenMolinaExamen\Lib\Route;
use RubenMolinaExamen\App\controllers\HomeController;



Route::get('/', [HomeController::class, 'login']);
Route::get('/principal', [HomeController::class, 'index']);
Route::get('/alta', [HomeController::class, 'alta']);


Route::handleRoute();
?>