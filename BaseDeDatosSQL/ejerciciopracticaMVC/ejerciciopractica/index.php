<?php
session_start();
require_once 'includes/config.php';
require_once APP_ROOT . "/models/ProductoModels.php";

// Verificar autenticación
if (!isset($_SESSION['usuario'])) {
    header("Location: login.php", true, 302);
    exit();
}

// Obtener productos
$productoModel = new ProductoModels();
$lista_productos = $productoModel->obtenerTodos();

// Obtener mensajes de sesión y limpiarlos
$mensaje = $_SESSION['mensaje'] ?? '';
$tipo_mensaje = $_SESSION['tipo_mensaje'] ?? '';

// Limpiar mensajes después de obtenerlos (forma más eficiente)
unset($_SESSION['mensaje'], $_SESSION['tipo_mensaje']);

// Cargar la vista
require_once APP_ROOT . '/views/index_view.php';
?>