<?php
// =============================================
// TU CÓDIGO PHP AQUÍ - EJERCICIO 2
// =============================================

$mensaje = "";
$peso_input = "";
$altura_input = "";
$errores = "";

function calcular($peso, $altura){
    $imc = $peso / ($altura * $altura);
    return $imc;
}

// 1. PROCESAR FORMULARIO CON MÉTODO POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // 2. OBTENER Y VALIDAR DATOS
    $peso_input = $_POST['peso'] ?? '';
    $altura_input = $_POST['altura'] ?? '';

    // 3. VALIDAR QUE NO ESTÉN VACÍOS
    // 4. VALIDAR QUE SEAN NÚMEROS VÁLIDOS
    if (empty($peso_input)) {
        $errores = "❌ Introduzca un dato para el peso.";
    } elseif (!is_numeric($peso_input) || $peso_input <= 0) {
        $errores = "❌ Introduzca un dato numérico mayor que 0 para el peso.";
    }

    if (empty($altura_input)) {
        $errores = "❌ Introduzca un dato para la altura.";
    } elseif (!is_numeric($altura_input) || $altura_input <= 0) {
        $errores = "❌ Introduzca un dato numérico mayor que 0 para la altura.";
    }

    // 5. CALCULAR EL IMC
    $clasificacion = "";
    if (empty($errores)) {
        $imc = calcular(floatval($peso_input), floatval($altura_input));

        // 6. DETERMINAR CLASIFICACIÓN
        if ($imc < 18.5) {
            $clasificacion = "Bajo peso";
        } elseif ($imc >= 18.5 && $imc <= 24.9) {
            $clasificacion = "Peso normal";
        } else {
            $clasificacion = "Sobrepeso";
        }
        
        // 7. MOSTRAR RESULTADO
        $mensaje = "✅ Tu IMC es: " . number_format($imc, 2) . " - Clasificación: $clasificacion";
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
    <title>Calculadora de IMC</title>
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
        .clasificacion { font-weight: bold; margin-top: 10px; }
    </style>
</head>
<body>
    <div class="container">
        <h1>⚖️ Calculadora de IMC</h1>
        
        <form method="POST">
            <div class="form-group">
                <label for="peso">Peso (kg):</label>
                <input type="number" step="0.1" id="peso" name="peso" value="<?php echo $peso_input; ?>" required>
            </div>
            
            <div class="form-group">
                <label for="altura">Altura (metros):</label>
                <input type="number" step="0.01" id="altura" name="altura" value="<?php echo $altura_input; ?>" required>
            </div>
            
            <button type="submit">📊 Calcular IMC</button>
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