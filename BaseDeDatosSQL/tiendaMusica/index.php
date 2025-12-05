<?php
session_start();
require_once 'includes/config.php';
require_once APP_ROOT . "/models/ProductoModels.php";

// Verificar autenticación
if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit();
}

$productoModel = new ProductoModels();

// Obtener mensajes de sesión si existen
$mensaje = $_SESSION['mensaje'] ?? '';
$tipo_mensaje = $_SESSION['tipo_mensaje'] ?? '';

// Limpiar los mensajes después de obtenerlos
if (isset($_SESSION['mensaje'])) {
    unset($_SESSION['mensaje'], $_SESSION['tipo_mensaje']);
}

// Obtener lista de productos
$lista_productos = $productoModel->obtenerTodos();

// Incluir la vista
require_once APP_ROOT . '/views/index_view.php';
?>