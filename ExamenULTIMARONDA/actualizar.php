<?php
session_start();
require_once "TicketModel.php";

// por si se intenta entrar directamente
if (!isset($_SESSION['usuario'])) {
    header("Location: login.php", true, 302);
}


$model = new TicketModel();



$id = $_GET['id'] ?? '';

if ($id === '') {
    $_SESSION['mensajeError'] = "Id incorrecta";
    header("Location: index.php", true, 302);
    exit();
}

$ticket = $model->obtenerPorID($id);


$estado = $ticket[0]['estado'];


$resultado = $model->cambiarEstado($id, $ticket[0]['estado']);

if ($resultado) {
    $_SESSION['mensajeExito'] = "Ticket actualizado correctamente.";
    header("Location: index.php", true, 302);
    exit();
} else {
     $_SESSION['mensajeError'] = "No se pudo actualizar correctamente.";
    header("Location: index.php", true, 302);
    exit();
}

// cambio el estado y redirigo


?>