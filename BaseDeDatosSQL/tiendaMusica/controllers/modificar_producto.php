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



// Inicializar variables (IMPORTANTE: hacerlo al principio)
$errores = [];
$mensaje = '';
$tipo_mensaje = '';
$producto = null;

// Obtener ID del producto a modificar (de GET o POST)
$id_producto = $_GET['id'] ?? $_POST['id_producto'] ?? null;

if (!$id_producto) {
    $_SESSION['mensaje'] = "Producto no encontrado";
    $_SESSION['tipo_mensaje'] = "error";
    header("Location: ../index.php");
    exit();
}

// Obtener datos actuales del producto
$producto = $productoModel->obtenerProductoPorId($id_producto);

// Si no se encontró el producto, redirigir
if (!$producto) {
    $_SESSION['mensaje'] = "Producto no encontrado";
    $_SESSION['tipo_mensaje'] = "error";
    header("Location: ../index.php");
    exit();
}

// Si se envió el formulario de modificación
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
        // Formatear precio
        $precio = (float) number_format($precio, 2, '.', '');
    }

    if (empty($errores)) {
        $resultado = $productoModel->actualizarProducto($id_producto, $nombre, $descripcion, $precio);
        
        if ($resultado) {
            // Guardar mensaje en sesión para mostrar en index.php
            $_SESSION['mensaje'] = "Producto actualizado correctamente.";
            $_SESSION['tipo_mensaje'] = "exito";
            
            // Redirigir al listado principal
            header("Location: ../index.php");
            exit();
        } else {
            // Mostrar error en esta misma página
            $mensaje = "Error al actualizar el producto.";
            $tipo_mensaje = "error";
        }
    } else {
        // Si hay errores de validación
        $mensaje = "Por favor, corrige los errores del formulario.";
        $tipo_mensaje = "error";
        
        // Mantener los datos enviados para mostrarlos en el formulario
        $producto = [
            'id_producto' => $id_producto,
            'nombre' => $nombre,
            'descripcion' => $descripcion,
            'precio' => $precio
        ];
    }
}

// Incluir la vista
require_once APP_ROOT . '/views/modificar_producto_view.php';
?>