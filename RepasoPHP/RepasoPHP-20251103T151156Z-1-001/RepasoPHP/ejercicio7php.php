<?php
// =============================================
// TU CÓDIGO PHP AQUÍ - EJERCICIO 7
// =============================================

$mensaje = "";
$texto_input = "";
$estadisticas = [];


function arrayALista($array, $titulo = '') {
    if (empty($array)) return "<p>No hay datos</p>";
    
    $html = '';
    if ($titulo) {
        $html .= "<h3>$titulo</h3>";
    }
    
    $html .= '<ul>';
    
    if (array_is_list($array)) {
        foreach ($array as $valor) {
            $html .= "<li>$valor</li>";
        }
    } else {
        foreach ($array as $clave => $valor) {
            $html .= "<li><strong>$clave:</strong> $valor</li>";
        }
    }
    
    $html .= '</ul>';
    return $html;
}

// 1. PROCESAR FORMULARIO CON MÉTODO POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // 2. OBTENER Y VALIDAR DATOS
    $texto_input = isset($_POST['texto']) ? htmlspecialchars(trim($_POST['texto'])) : '';
    
    // 3. VALIDAR: NO VACÍO Y MÁXIMO 500 CARACTERES
    if (empty($texto_input)) {
        $mensaje = "El texto no puede estar vacío.";
    } elseif (strlen($texto_input) > 500) {
        $mensaje = "El texto contiene demasiados caracteres (máximo 500)";
    } else {
        // 4. CALCULAR ESTADÍSTICAS
        
        $longitud = strlen($texto_input);
        $n_palabras = str_word_count($texto_input);
        $n_lineas = trim($texto_input) === '' ? 0 : substr_count($texto_input, "\n") + 1;

        // Palabra más larga y más corta
        $palabras = str_word_count($texto_input, 1);
        $palabra_mas_larga = '';
        $palabra_mas_corta = $palabras[0] ?? '';

        foreach ($palabras as $palabra) {
            if (strlen($palabra) > strlen($palabra_mas_larga)) {
                $palabra_mas_larga = $palabra;
            }
            if (strlen($palabra) < strlen($palabra_mas_corta)) {
                $palabra_mas_corta = $palabra;
            }
        }

        // Contar mayúsculas y minúsculas
        $contadorMayus = 0;
        $contadorMinus = 0;

        for ($i = 0; $i < $longitud; $i++) { 
            if (ctype_lower($texto_input[$i])) {
                $contadorMinus++;    
            } 
            if (ctype_upper($texto_input[$i])) {
                $contadorMayus++;
            }
        }

        // Calcular porcentajes (protegido contra división por cero)
        if ($longitud > 0) {
            $porcentajeMayus = ($contadorMayus / $longitud) * 100;
            $porcentajeMinus = ($contadorMinus / $longitud) * 100;
        } else {
            $porcentajeMayus = 0;
            $porcentajeMinus = 0;
        }
        
        // Formatear estadísticas para mostrar
        $estadisticas = [
            "Longitud total: $longitud caracteres",
            "Número de palabras: $n_palabras",
            "Número de líneas: $n_lineas",
            "Palabra más larga: '$palabra_mas_larga' (" . strlen($palabra_mas_larga) . " caracteres)",
            "Palabra más corta: '$palabra_mas_corta' (" . strlen($palabra_mas_corta) . " caracteres)",
            "Porcentaje mayúsculas: " . number_format($porcentajeMayus, 2) . "%",
            "Porcentaje minúsculas: " . number_format($porcentajeMinus, 2) . "%"
        ];

        // 5. MOSTRAR ESTADÍSTICAS
        $mensaje = arrayALista($estadisticas, "Estadísticas:");
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
    <title>Analizador de Texto Avanzado</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 40px; }
        .container { max-width: 600px; margin: 0 auto; }
        .form-group { margin: 15px 0; }
        label { display: block; margin-bottom: 5px; font-weight: bold; }
        textarea { width: 100%; height: 150px; padding: 10px; border: 2px solid #ddd; border-radius: 5px; }
        button { padding: 10px 20px; background: #007bff; color: white; border: none; border-radius: 5px; cursor: pointer; }
        button:hover { background: #0056b3; }
        .resultado { background: #e8f5e8; padding: 15px; border-radius: 8px; margin: 20px 0; }
        .error { background: #f8d7da; color: #721c24; padding: 15px; border-radius: 8px; }
        .estadisticas { background: #f0f8ff; padding: 15px; border-radius: 8px; margin: 15px 0; }
    </style>
</head>
<body>
    <div class="container">
        <h1>Analizador de Texto Avanzado</h1>
        
        <form method="POST">
            <div class="form-group">
                <label for="texto">Ingresa tu texto (máx. 500 caracteres):</label>
                <textarea id="texto" name="texto" maxlength="500" required><?php echo $texto_input; ?></textarea>
            </div>
            
            <button type="submit">Analizar Texto</button>
        </form>
        
        <?php if ($mensaje): ?>
            <div class="<?php echo strpos($mensaje, 'error') !== false ? 'error' : 'resultado'; ?>">
                <h2>Resultado:</h2>
                <?php echo $mensaje; ?>
            </div>
        <?php endif; ?>
        
        <?php if (!empty($estadisticas)): ?>
            <div class="estadisticas">
                <h2>Estadísticas del Texto:</h2>
                <?php foreach ($estadisticas as $estadistica): ?>
                    <p><?php echo $estadistica; ?></p>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>