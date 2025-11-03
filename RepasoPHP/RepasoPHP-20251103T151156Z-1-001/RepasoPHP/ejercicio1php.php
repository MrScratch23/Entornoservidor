<?php
// =============================================
// TU CÓDIGO PHP AQUÍ - EJERCICIO 1
// =============================================

$mensaje = "";
$euros_input = "";

function convertirEuros($euros) {
    $dolares = $euros * 1.10;
    return $dolares;
}

// 1. PROCESAR FORMULARIO CON MÉTODO GET
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['euros'])) {

    // 2. OBTENER Y VALIDAR DATOS
    $euros = $_GET['euros'] ?? '';
    $euros_input = $euros; // Mantener valor en el formulario

    // 3. VALIDAR QUE NO ESTÉ VACÍO
    if (empty($euros)) {
        $mensaje = "❌ El campo no puede estar vacío.";
    }
    // 4. VALIDAR QUE SEA UN NÚMERO VÁLIDO
    elseif (!is_numeric($euros) || $euros < 0) {
        $mensaje = "❌ Introduzca un número de euros correcto.";
    }
    // 5. REALIZAR LA CONVERSIÓN Y MOSTRAR RESULTADO
    else {
        $dolares = convertirEuros(floatval($euros));
        $mensaje = "✅ $euros € = " . number_format($dolares, 2) . " $";
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
    <title>Conversor de Monedas</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 40px; }
        .container { max-width: 500px; margin: 0 auto; }
        .form-group { margin: 15px 0; }
        label { display: block; margin-bottom: 5px; font-weight: bold; }
        input { padding: 10px; width: 200px; border: 2px solid #ddd; border-radius: 5px; }
        button { padding: 10px 20px; margin: 5px; background: #007bff; color: white; border: none; border-radius: 5px; cursor: pointer; }
        button:hover { background: #0056b3; }
        .resultado { background: #e8f5e8; padding: 15px; border-radius: 8px; margin: 20px 0; }
        .error { background: #f8d7da; color: #721c24; padding: 15px; border-radius: 8px; }
    </style>
</head>
<body>
    <div class="container">
        <h1>💱 Conversor EUR → USD</h1>
        <form method="GET">
            <div class="form-group">
                <label for="euros">Cantidad en Euros:</label>
                <input type="number" step="0.01" id="euros" name="euros" value="<?php echo htmlspecialchars($euros_input); ?>" required>
            </div>
            <button type="submit" name="convertir">🔄 Convertir</button>
            <button type="reset" name="limpiar">🧹 Limpiar</button>
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