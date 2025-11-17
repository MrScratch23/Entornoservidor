<?php
session_start();

function arrayATabla($array, $titulo = '') {
    if (empty($array)) return "<p>No hay datos</p>";
    
    $html = '';
    if ($titulo) {
        $html .= "<h3>$titulo</h3>";
    }
    
    $html .= '<table border="1" style="border-collapse: collapse; width: 100%;">';
    
    // Detectar si es array de arrays
    $esMultidimensional = is_array($array[0] ?? null);
    
    if ($esMultidimensional) {
        // Generar encabezados desde las keys del primer elemento
        $html .= '<tr>';
        foreach (array_keys($array[0]) as $header) {
            $html .= "<th style='padding: 8px;'>" . htmlspecialchars($header) . "</th>";
        }
        $html .= '</tr>';
        
        // Generar filas
        foreach ($array as $fila) {
            $html .= '<tr>';
            foreach ($fila as $valor) {
                $html .= "<td style='padding: 8px;'>" . htmlspecialchars($valor) . "</td>";
            }
            $html .= '</tr>';
        }
    } else {
        // Array simple
        $html .= '<tr>';
        foreach ($array as $valor) {
            $html .= "<td style='padding: 8px;'>" . htmlspecialchars($valor) . "</td>";
        }
        $html .= '</tr>';
    }
    
    $html .= '</table>';
    return $html;
}

function cargarDatosSUPER($archivo, $formato = 'indexado')
{
    $datos = [];
    if (!file_exists($archivo)) return $datos;
    
    $manejador = @fopen($archivo, "r");
    if ($manejador) {
        // Leer primera línea para detectar encabezados
        $primeraLinea = fgetcsv($manejador);
        if ($primeraLinea === false) {
            fclose($manejador);
            return $datos;
        }
        
        // Verificar si la primera línea parece encabezados (no numérica)
        $tieneEncabezados = false;
        if ($formato === 'auto') {
            $tieneEncabezados = !is_numeric(trim($primeraLinea[0]));
        }
        
        // Si tiene encabezados, procesar de forma asociativa
        if ($tieneEncabezados) {
            $encabezados = $primeraLinea;
            while (!feof($manejador)) {
                $temp = fgetcsv($manejador);
                if ($temp === false || (count($temp) === 1 && empty(trim($temp[0])))) continue;
                
                $fila = [];
                foreach ($encabezados as $index => $encabezado) {
                    $fila[trim($encabezado)] = $temp[$index] ?? '';
                }
                $datos[] = $fila;
            }
        } else {
            // Si no tiene encabezados, procesar como indexado
            $datos[] = $primeraLinea; // Guardar la primera línea también
            while (!feof($manejador)) {
                $temp = fgetcsv($manejador);
                if ($temp === false || (count($temp) === 1 && empty(trim($temp[0])))) continue;
                $datos[] = $temp;
            }
        }
        
        fclose($manejador);
    }
    return $datos;
}


$usuario = $_SESSION['usuario'];
$puntuacion = $_SESSION['puntuacion_actual'];
$cartas = $_SESSION['cartas'];
$archivo = "datos_blackjack.csv";
$resultado = $_SESSION['resultado'];

$mensajeHistorial = cargarDatosSUPER($archivo, 'auto');


?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resultado - Blackjack</title>
    <link rel="stylesheet" href="https://cdn.simplecss.org/simple.min.css">
    <style>
        .mensaje {
            padding: 20px;
            border-radius: 8px;
            margin: 20px 0;
            font-size: 18px;
            font-weight: bold;
            text-align: center;
        }
        .ganador { background: #d4edda; color: #155724; border: 2px solid #155724; }
        .perdedor { background: #f8d7da; color: #721c24; border: 2px solid #721c24; }
        .empate { background: #fff3cd; color: #856404; border: 2px solid #856404; }
    </style>
</head>
<body>
    <h1>♠️ ♥️ Resultado del Blackjack ♦️ ♣️</h1>
    
    <h2>Jugador:<?php
    echo $usuario;
    ?></h2>

    <!-- Resultado -->
    <div class="mensaje <!-- PHP añadirá la clase según resultado -->">
        <?php
        echo $resultado;
        ?>
    </div>

    <!-- Puntuación final -->
    <div style="text-align: center; margin: 20px 0;">
        <h3>Puntuación Final: <?php
        echo $puntuacion;
        ?></h3>
    </div>

    <!-- Cartas finales -->
    <div style="text-align: center;">
        <h3>Tus Cartas:</h3>
            
    <?php foreach ($cartas as $carta): ?>
        <div class="carta"><?php echo $carta; ?></div>
    <?php endforeach; ?>
    </div>

    <!-- Historial reciente -->
    <div style="margin: 30px 0;">
        <h3>Tu Historial Reciente:</h3>
        <?php
        echo arrayATabla($mensajeHistorial);    
        ?>
    </div>

    <!-- Opciones -->
   <form method="post" action="reiniciar_juego.php" style="display: inline;">
    <button type="submit" style="padding: 10px 20px; font-size: 16px;">Jugar Otra Vez</button>
</form>
        
        <a href="index.php" style="margin-left: 20px; padding: 10px 20px; font-size: 16px;">
            Cambiar de Usuario
        </a>
    </div>
</body>
</html>