<?php
require_once '../includes/config.php';
require_once APP_ROOT . "/models/ProductoModels.php";

$productoModel = new ProductoModels();

// Obtener ID del producto a eliminar
$id_producto = $_GET['id'] ?? null;

if ($id_producto) {
    // Eliminar el producto
    $resultado = $productoModel->eliminarProducto($id_producto);
    
    if ($resultado) {
        $mensaje = "Producto eliminado correctamente.";
        $tipo_mensaje = "exito";
    } else {
        $mensaje = "Error al eliminar el producto.";
        $tipo_mensaje = "error";
    }
} else {
    $mensaje = "ID de producto no válido.";
    $tipo_mensaje = "error";
}

// Redirigir de vuelta al index con mensaje
header("Location: ../index.php?mensaje=" . urlencode($mensaje) . "&tipo=" . $tipo_mensaje);
exit();
?>