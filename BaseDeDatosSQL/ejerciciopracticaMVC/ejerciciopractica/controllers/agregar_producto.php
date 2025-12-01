<?php
require_once '../includes/config.php';
require_once APP_ROOT . "/models/ProductoModels.php";

$productoModel = new ProductoModels();
$mensaje = "";
$tipo_mensaje = "";

// Si se envió el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'] ?? '';
    $descripcion = $_POST['descripcion'] ?? '';
    $precio = $_POST['precio'] ?? 0;
    
    $resultado = $productoModel->crearProducto($nombre, $descripcion, $precio);
    
    if ($resultado) {
        $mensaje = "Producto creado correctamente.";
        $tipo_mensaje = "exito";
        // Limpiar el formulario
        $_POST = [];
    } else {
        $mensaje = "Error al crear el producto.";
        $tipo_mensaje = "error";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Agregar Nuevo Producto</title>
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
    <h1>Agregar Nuevo Producto</h1>
    
    <?php if ($mensaje): ?>
        <div class="mensaje <?php echo $tipo_mensaje; ?>">
            <?php echo $mensaje; ?>
        </div>
    <?php endif; ?>

    <form method="POST">
        <div class="form-group">
            <label>Nombre:</label>
            <input type="text" name="nombre" value="<?php echo htmlspecialchars($_POST['nombre'] ?? ''); ?>" required>
        </div>
        
        <div class="form-group">
            <label>Descripción:</label>
            <textarea name="descripcion" rows="4" required><?php echo htmlspecialchars($_POST['descripcion'] ?? ''); ?></textarea>
        </div>
        
        <div class="form-group">
            <label>Precio (€):</label>
            <input type="number" name="precio" step="0.01" min="0" value="<?php echo $_POST['precio'] ?? ''; ?>" required>
        </div>
        
        <button type="submit" class="btn btn-guardar">➕ Crear Producto</button>
        <a href="../index.php" class="btn btn-cancelar">↩️ Volver al Listado</a>
    </form>
</body>
</html>