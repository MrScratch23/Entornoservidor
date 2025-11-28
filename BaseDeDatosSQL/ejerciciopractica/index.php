<?php

require_once 'includes/config.php';

require_once APP_ROOT . "/models/ProductoModels.php";

$productoModel = new ProductoModels();
$mensaje = "null";
$tipo_mensaje = "";


$filas = $productoModel->crearProducto("Raton optico", "1200 DPI con cable", 12.50);

if ($filas) {
    $mensaje = "Producto insertado correctamente.";
    $tipo_mensaje = "exito";
} else {
    $mensaje = "Error al insertar producto";
    $tipo_mensaje = "error";
}

$lista_productos = $productoModel->obtenerTodos();

require_once APP_ROOT . '/views/index_view.php';


?>