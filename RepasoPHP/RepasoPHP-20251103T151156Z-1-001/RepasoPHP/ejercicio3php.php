<?php
// =============================================
// TU CÓDIGO PHP AQUÍ - EJERCICIO 3
// =============================================

$mensaje = "";
$nombre_input = "";
$precio_input = "";
$categoria_input = "";
$errores = "";

// 1. PROCESAR FORMULARIO CON MÉTODO POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // 2. OBTENER Y VALIDAR DATOS
    $nombre_input = isset($_POST['nombre']) ? htmlspecialchars($_POST['nombre']) : '';
    $precio_input = $_POST['precio'] ?? '';
    $categoria_input = isset($_POST['categoria']) ? htmlspecialchars($_POST['categoria']) : '';

    // 3. VALIDAR LONGITUD DEL NOMBRE
    if (empty($nombre_input)) {
        $errores .= "El nombre no puede estar vacío.<br>";
    } elseif (strlen($nombre_input) > 30) {
        $errores .= "El nombre no puede tener más de 30 caracteres.<br>";
    }

    // 4. VALIDAR PRECIO
    if (empty($precio_input)) {
        $errores .= "El precio no puede estar vacío.<br>";
    } elseif (!is_numeric($precio_input) || floatval($precio_input) <= 0) {
        $errores .= "El precio debe ser un número mayor que 0.<br>";
    }

    // 5. VALIDAR CATEGORÍA
    if (empty($categoria_input)) {
        $errores .= "Debe seleccionar una categoría.<br>";
    }

    // 6. MOSTRAR MENSAJE DE ÉXITO O ERROR
    if (empty($errores)) {
        $precio_formateado = number_format(floatval($precio_input), 2);
        $mensaje = "Producto '$nombre_input' registrado correctamente - Precio: {$precio_formateado}€ - Categoría: $categoria_input";
    } else {
        $mensaje = $errores;
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
    <title>Registro de Productos</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 40px; }
        .container { max-width: 500px; margin: 0 auto; }
        .form-group { margin: 15px 0; }
        label { display: block; margin-bottom: 5px; font-weight: bold; }
        input, select { padding: 10px; width: 200px; border: 2px solid #ddd; border-radius: 5px; }
        button { padding: 10px 20px; background: #007bff; color: white; border: none; border-radius: 5px; cursor: pointer; }
        button:hover { background: #0056b3; }
        .resultado { background: #e8f5e8; padding: 15px; border-radius: 8px; margin: 20px 0; }
        .error { background: #f8d7da; color: #721c24; padding: 15px; border-radius: 8px; }
    </style>
</head>
<body>
    <div class="container">
        <h1>🛍️ Registro de Productos</h1>
        
        <form method="POST">
            <div class="form-group">
                <label for="nombre">Nombre del Producto:</label>
                <input type="text" id="nombre" name="nombre" value="<?php echo $nombre_input; ?>" maxlength="30" required>
            </div>
            
            <div class="form-group">
                <label for="precio">Precio (€):</label>
                <input type="number" step="0.01" id="precio" name="precio" value="<?php echo $precio_input; ?>" required>
            </div>
            
            <div class="form-group">
                <label for="categoria">Categoría:</label>
                <select id="categoria" name="categoria" required>
                    <option value="">Selecciona categoría</option>
                    <option value="electronica" <?php echo ($categoria_input == 'electronica') ? 'selected' : ''; ?>>Electrónica</option>
                    <option value="ropa" <?php echo ($categoria_input == 'ropa') ? 'selected' : ''; ?>>Ropa</option>
                    <option value="hogar" <?php echo ($categoria_input == 'hogar') ? 'selected' : ''; ?>>Hogar</option>
                    <option value="deportes" <?php echo ($categoria_input == 'deportes') ? 'selected' : ''; ?>>Deportes</option>
                </select>
            </div>
            
            <button type="submit">💾 Registrar Producto</button>
        </form>
        
        <?php if ($mensaje): ?>
            <div class="<?php echo strpos($mensaje, '❌') !== false ? 'error' : 'resultado'; ?>">
                <h2>Resultado:</h2>
                <?php echo $mensaje; ?>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>