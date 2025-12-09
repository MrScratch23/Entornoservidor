<?php
session_start();
require_once "TicketModel.php";

if (!isset($_SESSION['usuario'])) {
    header("Location: login", true, 302);
    exit();
}


$model = new TicketModel();

$id = $_GET['id'] ?? '';

if ($id === '') {
    $_SESSION['mensajeError'] = "Id incorrecta";
    header("Location: index.php", true, 302);
    exit();
}

// una vez recogida el id por get, lo introduzco en el modelo para eliminarlo
$ticket = $model->eliminarPorID($id);

if ($ticket) {
    $_SESSION['mensajeExito'] = "Ticket eliminado correctamente.";
    header("Location: index.php", true, 302);
    exit();
} else {
    $_SESSION['mensajeError'] = "No se pudo eliminar el ticket.";
    header("Location: index.php", true, 302);
    exit();
}


?>
