<?php
session_start();

// Si ya está logueado, redirigir
if (isset($_SESSION['usuario'])) {
    header("Location: juego.php");
    exit();
}

// Si NO es POST, redirigir a index
if ($_SERVER['REQUEST_METHOD'] !== "POST") {
    header("Location:index.php");
    exit();
}

// A partir de aquí SABEMOS que es POST
$archivo = "data/usuarios.txt";
$error = "";

// Obtener y limpiar datos
$nombre = htmlspecialchars(trim($_POST['nombre'] ?? ''));

// Validaciones
if ($nombre === '') {
    $error = "El nombre no puede estar vacio.";
} elseif (strlen($nombre) > 20 || strlen($nombre) < 2) {
    $error = "El nombre debe contener entre 2-20 caracteres.";
}

// Manejar errores
if (!empty($error)) {
    $_SESSION['error'] = $error;
    header("Location: index.php");
    exit();
}

// Si todo OK
$_SESSION['usuario'] = $nombre;
$_SESSION['puntos'] = 0;
$_SESSION['aciertos'] = 0;
$_SESSION['fallos'] = 0;
$_SESSION['turno'] = 1;
$_SESSION['preguntas_respondidas'] = [];

$fecha = date('Y-m-d H:i:s');
$linea = "$nombre - $fecha\n";

// Guardar en archivo
file_put_contents($archivo, $linea, FILE_APPEND | LOCK_EX);

// Redirigir a juego
header("Location:juego.php", true, 302);
exit();
?>