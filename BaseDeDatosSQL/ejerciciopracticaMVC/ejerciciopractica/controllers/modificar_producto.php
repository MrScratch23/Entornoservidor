<?php
session_start(); // AGREGADO: Iniciar sesión al principio
require_once '../includes/config.php';
require_once APP_ROOT . "/models/ProductoModels.php";

$productoModel = new ProductoModels();

// Obtener ID del producto a modificar
$id_producto = $_GET['id'] ?? null;
$errores = [];
// Obtener datos actuales del producto
$producto = null;
if ($id_producto) {
    $producto = $productoModel->obtenerProductoPorId($id_producto);
}

// Si se envió el formulario de modificación
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'] ?? '';
    $descripcion = $_POST['descripcion'] ?? '';
    $precio = $_POST['precio'] ?? '';

    
    if ($nombre === '') {
        $errores['nombre'] = "El campo nombre debe debe estar relleno.";
    }
    if ($precio === '') {
        $errores['precio'] = "El precio debe estar relleno.";
    }

if (empty($errores)) {
       
    if ($id_producto) {
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
}

 
    }
}

// Si no se encontró el producto, redirigir
if (!$producto && !$_POST) {
    $_SESSION['mensaje'] = "Producto no encontrado";
    $_SESSION['tipo_mensaje'] = "error";
    header("Location: ../index.php");
    exit();
}

// Obtener mensajes locales para esta página (si no hubo redirección)
$mensaje = $mensaje ?? '';
$tipo_mensaje = $tipo_mensaje ?? '';
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Modificar Producto</title>
    <style>
        body { font-family: sans-serif; padding: 20px; max-width: 600px; margin: 0 auto; }
        .form-group { margin-bottom: 15px; }
        label { display: block; margin-bottom: 5px; font-weight: bold; }
        input, textarea { width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px; box-sizing: border-box; }
        .btn { padding: 10px 15px; border: none; border-radius: 4px; cursor: pointer; text-decoration: none; display: inline-block; }
        .btn-guardar { background-color: #28a745; color: white; }
        .btn-cancelar { background-color: #6c757d; color: white; }
        .mensaje { padding: 10px; margin-bottom: 20px; border-radius: 5px; }
        .exito { background-color: #d4edda; color: #155724; }
        .error { background-color: #f8d7da; color: #721c24; }
    </style>
</head>
<body>
    <h1>Modificar Producto</h1>
    
    <?php if ($mensaje): ?>
        <div class="mensaje <?php echo htmlspecialchars($tipo_mensaje); ?>">
            <?php echo htmlspecialchars($mensaje); ?>
        </div>
    <?php endif; ?>

    <form method="POST">
        <div class="form-group">
            <label>Nombre:</label>
            <input type="text" name="nombre" value="<?php echo htmlspecialchars($producto['nombre'] ?? ''); ?>" >
            <?php if (isset($errores['nombre'])): ?>
                <br><span style="color: red;"><?php echo $errores['nombre']; ?></span>
            <?php endif; ?>
        </div>
        
        <div class="form-group">
            <label>Descripción:</label>
            <textarea name="descripcion" rows="4"><?php echo htmlspecialchars($producto['descripcion'] ?? ''); ?></textarea>
        </div>
        
        <div class="form-group">
            <label>Precio (€):</label>
            <input type="number" name="precio" step="0.01" min="0" value="<?php echo htmlspecialchars($producto['precio'] ?? ''); ?>" >
            <?php if (isset($errores['precio'])): ?>
                <br><span style="color: red;"><?php echo $errores['precio']; ?></span>
            <?php endif; ?>
        </div>
        
        <button type="submit" class="btn btn-guardar">💾 Guardar Cambios</button>
        <a href="../index.php" class="btn btn-cancelar">❌ Cancelar</a>
    </form>
</body>
</html>