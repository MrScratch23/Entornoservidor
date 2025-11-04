<?php
// =============================================
// TU CÓDIGO PHP AQUÍ - EJERCICIO 6
// =============================================

$mensaje = "";
$producto_input = "";
$lista_compras = [];

// 1. PROCESAR FORMULARIO CON MÉTODO POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    // 2. OBTENER DATOS DEL FORMULARIO
    $producto_input = isset($_POST['producto']) ? htmlspecialchars(trim($_POST['producto'])) : '';
    
    // 3. CARGAR LISTA EXISTENTE DESDE CAMPO OCULTO
    if (isset($_POST['lista_serializada']) && !empty($_POST['lista_serializada'])) {
        $lista_compras = unserialize($_POST['lista_serializada']);
    }
    
    // 4. MANEJAR BOTÓN "AGREGAR"
    if (isset($_POST['agregar'])) {
        // VALIDAR QUE EL PRODUCTO NO ESTÉ VACÍO
        if (empty($producto_input)) {
            $mensaje = "Introduzca el nombre del producto.";
        } else {
            // AGREGAR PRODUCTO AL ARRAY
            $lista_compras[] = $producto_input;
            $mensaje = "Producto '$producto_input' agregado correctamente.";
            $producto_input = ""; // Limpiar el input después de agregar
        }
    }
    
    // 5. MANEJAR BOTÓN "LIMPIAR LISTA"
    if (isset($_POST['limpiar'])) {
        $lista_compras = [];
        $mensaje = "Lista limpiada correctamente.";
    }
}
// =============================================
// FIN DE TU CÓDIGO PHP
// =============================================
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Lista de Compras</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 40px; }
        .container { max-width: 500px; margin: 0 auto; }
        .form-group { margin: 15px 0; }
        label { display: block; margin-bottom: 5px; font-weight: bold; }
        input { padding: 10px; width: 200px; border: 2px solid #ddd; border-radius: 5px; }
        button { padding: 10px 20px; margin: 5px; background: #007bff; color: white; border: none; border-radius: 5px; cursor: pointer; }
        button:hover { background: #0056b3; }
        .btn-limpiar { background: #dc3545; }
        .btn-limpiar:hover { background: #c82333; }
        .lista { background: #f0f8ff; padding: 15px; border-radius: 8px; margin: 15px 0; }
        .resultado { background: #e8f5e8; padding: 15px; border-radius: 8px; margin: 20px 0; }
        .error { background: #f8d7da; color: #721c24; padding: 15px; border-radius: 8px; }
    </style>
</head>
<body>
    <div class="container">
        <h1>Lista de Compras</h1>
        
        <form method="POST">
            <div class="form-group">
                <label for="producto">Producto:</label>
                <input type="text" id="producto" name="producto" value="<?php echo $producto_input; ?>" required>
            </div>
            
            <!-- CAMPO OCULTO PARA MANTENER LA LISTA -->
            <input type="hidden" name="lista_serializada" value="<?php echo serialize($lista_compras); ?>">
            
            <button type="submit" name="agregar">Agregar</button>
            <button type="submit" name="limpiar" class="btn-limpiar">Limpiar Lista</button>
        </form>
        
        <div class="lista">
            <h2>Lista Actual:</h2>
            <?php if (!empty($lista_compras)): ?>
                <ul>
                    <?php foreach ($lista_compras as $producto): ?>
                        <li><?php echo $producto; ?></li>
                    <?php endforeach; ?>
                </ul>
                <p><strong>Total: <?php echo count($lista_compras); ?> productos</strong></p>
            <?php else: ?>
                <p>No hay productos en la lista</p>
            <?php endif; ?>
        </div>
        
        <div class="resultado">
            <?php echo $mensaje; ?>
        </div>
    </div>
</body>
</html>