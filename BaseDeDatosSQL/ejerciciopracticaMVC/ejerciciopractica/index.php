<?php
session_start();
require_once 'includes/config.php';
require_once APP_ROOT . "/models/ProductoModels.php";

$productoModel = new ProductoModels();

// Obtener productos
$lista_productos = $productoModel->obtenerTodos();

// Obtener mensajes de sesión y limpiarlos
$mensaje = $_SESSION['mensaje'] ?? '';
$tipo_mensaje = $_SESSION['tipo_mensaje'] ?? '';

// Limpiar mensajes después de obtenerlos
if (isset($_SESSION['mensaje'])) {
    unset($_SESSION['mensaje']);
}
if (isset($_SESSION['tipo_mensaje'])) {
    unset($_SESSION['tipo_mensaje']);
}

// Cargar la vista
require_once APP_ROOT . '/views/index_view.php';