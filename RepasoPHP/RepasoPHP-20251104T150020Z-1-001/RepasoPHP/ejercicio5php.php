<?php
// =============================================
// TU CÓDIGO PHP AQUÍ - EJERCICIO 5
// =============================================

$mensaje = "";
$numero_input = "";
$primos = [];

function esPrimo($numero) {
    if ($numero < 2) return false;
    for ($i = 2; $i <= sqrt($numero); $i++) {
        if ($numero % $i == 0) return false;
    }
    return true;
}

// 1. PROCESAR FORMULARIO CON MÉTODO POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    // 2. OBTENER Y VALIDAR DATOS
    $numero_input = $_POST['numero'] ?? '';  // CORRECCIÓN: 'numero' en lugar de 'elemento'
    $numero = intval($numero_input);

    // 3. VALIDAR QUE EL NÚMERO ESTÉ ENTRE 1 Y 100
    if (empty($numero_input)) {
        $mensaje = "El campo no puede estar vacío";
    } elseif (!is_numeric($numero_input)) {
        $mensaje = "Introduce un número correcto";
    } elseif ($numero < 1 || $numero > 100) {
        $mensaje = "El número debe estar entre 1 y 100";
    } else {
        // 4. FUNCIÓN PARA VERIFICAR SI UN NÚMERO ES PRIMO (ya definida arriba)
        
        // 5. GENERAR TODOS LOS NÚMEROS PRIMOS HASTA EL NÚMERO INGRESADO
        for ($i = 2; $i <= $numero; $i++) {
            if (esPrimo($i)) {
                $primos[] = $i;
            }
        }

        // 6. MOSTRAR LOS NÚMEROS PRIMOS ENCONTRADOS
        if (!empty($primos)) {
            $mensaje = "Números primos encontrados hasta $numero:<br><ul>";
            foreach ($primos as $primo) {
                $mensaje .= "<li>$primo</li>";
            }
            $mensaje .= "</ul>Total: " . count($primos) . " números primos";
        } else {
            $mensaje = "No se encontraron números primos hasta $numero";
        }
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
    <title>Generador de Números Primos</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 40px; }
        .container { max-width: 500px; margin: 0 auto; }
        .form-group { margin: 15px 0; }
        label { display: block; margin-bottom: 5px; font-weight: bold; }
        input { padding: 10px; width: 200px; border: 2px solid #ddd; border-radius: 5px; }
        button { padding: 10px 20px; background: #007bff; color: white; border: none; border-radius: 5px; cursor: pointer; }
        button:hover { background: #0056b3; }
        .resultado { background: #e8f5e8; padding: 15px; border-radius: 8px; margin: 20px 0; }
        .error { background: #f8d7da; color: #721c24; padding: 15px; border-radius: 8px; }
        .primos { background: #f0f8ff; padding: 15px; border-radius: 8px; margin: 15px 0; }
    </style>
</head>
<body>
    <div class="container">
        <h1>Generador de Números Primos</h1>
        
        <form method="POST">
            <div class="form-group">
                <label for="numero">Número máximo (1-100):</label>
                <input type="number" id="numero" name="numero" value="<?php echo $numero_input; ?>" min="1" max="100" required>
            </div>
            
            <button type="submit">Generar Primos</button>
        </form>
        
        <?php if ($mensaje): ?>
            <div class="<?php echo strpos($mensaje, 'error') !== false ? 'error' : 'resultado'; ?>">
                <h2>Resultado:</h2>
                <?php echo $mensaje; ?>
            </div>
        <?php endif; ?>
        
        <?php if (!empty($primos)): ?>
            <div class="primos">
                <h2>Números Primos encontrados:</h2>
                <p><?php echo implode(', ', $primos); ?></p>
                <p><strong>Total: <?php echo count($primos); ?> números primos</strong></p>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>