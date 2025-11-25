<?php
session_start();
require_once 'dataset.php';

$id = $_GET['id'] ?? '';

// Validar ID
if ($id === '' || !isset($viajes[$id])) {
    header("Location: index.php");
    exit();
}

// Inicializar array de reservas
if (!isset($_SESSION['reservas']) || !is_array($_SESSION['reservas'])) {
    $_SESSION['reservas'] = [];
}

// Verificar si ya está reservado
if (in_array($id, $_SESSION['reservas'])) {
    $_SESSION['mensajeflash'] = "❌ Este viaje ya estaba reservado";
} else {
    // Añadir a reservas
    $_SESSION['reservas'][] = $id;
    $_SESSION['mensajeflash'] = "✅ Viaje '" . $viajes[$id]['destino'] . "' reservado correctamente";
}

header("Location: index.php");
exit();
?>