<?php
session_start();
require_once '../includes/config.php';
require_once APP_ROOT . "/models/ProductoModels.php";

// Verificar autenticación
if (!isset($_SESSION['usuario'])) {
    header("Location: ../login.php");
    exit();
}

$productoModel = new ProductoModels();
$errores = [];
$mensaje = '';
$tipo_mensaje = '';

// Si se envió el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = trim($_POST['nombre'] ?? '');
    $descripcion = trim($_POST['descripcion'] ?? '');
    $precio = $_POST['precio'] ?? '';
    
    // Validaciones
    if (empty($nombre)) {
        $errores['nombre'] = "El campo nombre debe estar relleno.";
    }
    
    if (empty($precio)) {
        $errores['precio'] = "El precio debe estar relleno.";
    } elseif (!is_numeric($precio) || $precio <= 0) {
        $errores['precio'] = "El precio debe ser un número mayor que 0.";
    } else {
        // Convertir a float con 2 decimales
        $precio = (float) number_format($precio, 2, '.', '');
    }

    if (empty($errores)) {
        $resultado = $productoModel->crearProducto($nombre, $descripcion, $precio);
        
        if ($resultado) {
            // Guardar mensaje en sesión para mostrar en index.php
            $_SESSION['mensaje'] = "Producto creado correctamente.";
            $_SESSION['tipo_mensaje'] = "exito";
            
            // Redirigir al listado principal
            header("Location: ../index.php");
            exit();
        } else {
            // Mostrar error en esta misma página
            $mensaje = "Error al crear el producto. Verifica los datos.";
            $tipo_mensaje = "error";
        }
    } else {
        // Si hay errores de validación
        $mensaje = "Por favor, corrige los errores del formulario.";
        $tipo_mensaje = "error";
    }
}

// Incluir la vista (SOLO si es GET o si hay errores en POST)
require_once APP_ROOT . '/views/agregar_producto_view.php';
?>