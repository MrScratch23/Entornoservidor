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

// Eliminar de reservas
if (($key = array_search($id, $_SESSION['reservas'])) !== false) {
    unset($_SESSION['reservas'][$key]);
    $_SESSION['reservas'] = array_values($_SESSION['reservas']); // Reindexar
    $_SESSION['mensajeflash'] = "✅ Viaje '" . $viajes[$id]['destino'] . "' eliminado de reservas";
} else {
    $_SESSION['mensajeflash'] = "❌ Este viaje no estaba reservado";
}

header("Location: index.php");
exit();
?>