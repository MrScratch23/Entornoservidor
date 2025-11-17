<?php
session_start();

// Reiniciar solo las variables del juego, mantener el usuario
$_SESSION['puntuacion_actual'] = 0;
$_SESSION['cartas'] = [];
$_SESSION['juego_terminado'] = false;
$_SESSION['resultado'] = 'jugando';
$_SESSION['intentos'] = 0;

// Redirigir de vuelta al juego
header("Location: juego.php", true, 302);
exit();
?>