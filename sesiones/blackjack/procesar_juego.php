<?php

session_start();

$cartas_posibles = [
    ['valor' => 'A', 'palo' => '♥', 'puntos' => 11],
    ['valor' => '2', 'palo' => '♥', 'puntos' => 2],
    ['valor' => '3', 'palo' => '♥', 'puntos' => 3],
    ['valor' => '4', 'palo' => '♥', 'puntos' => 4],
    ['valor' => '5', 'palo' => '♥', 'puntos' => 5],
    ['valor' => '6', 'palo' => '♥', 'puntos' => 6],
    ['valor' => '7', 'palo' => '♥', 'puntos' => 7],
    ['valor' => '8', 'palo' => '♥', 'puntos' => 8],
    ['valor' => '9', 'palo' => '♥', 'puntos' => 9],
    ['valor' => '10', 'palo' => '♥', 'puntos' => 10],
    ['valor' => 'J', 'palo' => '♥', 'puntos' => 10],
    ['valor' => 'Q', 'palo' => '♥', 'puntos' => 10],
    ['valor' => 'K', 'palo' => '♥', 'puntos' => 10],
    
    ['valor' => 'A', 'palo' => '♦', 'puntos' => 11],
    ['valor' => '2', 'palo' => '♦', 'puntos' => 2],
    ['valor' => '3', 'palo' => '♦', 'puntos' => 3],
    ['valor' => '4', 'palo' => '♦', 'puntos' => 4],
    ['valor' => '5', 'palo' => '♦', 'puntos' => 5],
    ['valor' => '6', 'palo' => '♦', 'puntos' => 6],
    ['valor' => '7', 'palo' => '♦', 'puntos' => 7],
    ['valor' => '8', 'palo' => '♦', 'puntos' => 8],
    ['valor' => '9', 'palo' => '♦', 'puntos' => 9],
    ['valor' => '10', 'palo' => '♦', 'puntos' => 10],
    ['valor' => 'J', 'palo' => '♦', 'puntos' => 10],
    ['valor' => 'Q', 'palo' => '♦', 'puntos' => 10],
    ['valor' => 'K', 'palo' => '♦', 'puntos' => 10],
    
    ['valor' => 'A', 'palo' => '♣', 'puntos' => 11],
    ['valor' => '2', 'palo' => '♣', 'puntos' => 2],
    ['valor' => '3', 'palo' => '♣', 'puntos' => 3],
    ['valor' => '4', 'palo' => '♣', 'puntos' => 4],
    ['valor' => '5', 'palo' => '♣', 'puntos' => 5],
    ['valor' => '6', 'palo' => '♣', 'puntos' => 6],
    ['valor' => '7', 'palo' => '♣', 'puntos' => 7],
    ['valor' => '8', 'palo' => '♣', 'puntos' => 8],
    ['valor' => '9', 'palo' => '♣', 'puntos' => 9],
    ['valor' => '10', 'palo' => '♣', 'puntos' => 10],
    ['valor' => 'J', 'palo' => '♣', 'puntos' => 10],
    ['valor' => 'Q', 'palo' => '♣', 'puntos' => 10],
    ['valor' => 'K', 'palo' => '♣', 'puntos' => 10],
    
    ['valor' => 'A', 'palo' => '♠', 'puntos' => 11],
    ['valor' => '2', 'palo' => '♠', 'puntos' => 2],
    ['valor' => '3', 'palo' => '♠', 'puntos' => 3],
    ['valor' => '4', 'palo' => '♠', 'puntos' => 4],
    ['valor' => '5', 'palo' => '♠', 'puntos' => 5],
    ['valor' => '6', 'palo' => '♠', 'puntos' => 6],
    ['valor' => '7', 'palo' => '♠', 'puntos' => 7],
    ['valor' => '8', 'palo' => '♠', 'puntos' => 8],
    ['valor' => '9', 'palo' => '♠', 'puntos' => 9],
    ['valor' => '10', 'palo' => '♠', 'puntos' => 10],
    ['valor' => 'J', 'palo' => '♠', 'puntos' => 10],
    ['valor' => 'Q', 'palo' => '♠', 'puntos' => 10],
    ['valor' => 'K', 'palo' => '♠', 'puntos' => 10]
];

function guardarArrayAsociativoCSV($archivo, $arrayAsociativo) {
    $handle = fopen($archivo, 'a');
    if (filesize($archivo) == 0) {
        fputcsv($handle, array_keys($arrayAsociativo));
    }
    fputcsv($handle, array_values($arrayAsociativo));
    fclose($handle);
    return true;
}

$archivo = "datos_blackjack.csv";

if (!isset($_SESSION['usuario'])) {
    header("Location: index.php", true, 302);
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $accion = $_POST['accion'] ?? '';

    if (empty($accion)) {
        echo "Debe procesar una accion.";
        exit();
    }

    if ($accion === "pedir_carta") {
        $indice = array_rand($cartas_posibles, 1);
        $nuevaCarta = $cartas_posibles[$indice];
        $_SESSION['puntuacion_actual'] += $nuevaCarta['puntos'];
        array_push($_SESSION['cartas'], $nuevaCarta['valor'] . $nuevaCarta['palo']);
        $_SESSION['intentos']++;

        // VERIFICAR y GUARDAR antes de redirigir
        if ($_SESSION['puntuacion_actual'] > 21) {
            $_SESSION['resultado'] = "perdió";
            $_SESSION['juego_terminado'] = true;
            
            $resultado = [
                "usuario" => $_SESSION['usuario'],
                "puntuacion" => $_SESSION['puntuacion_actual'],
                "resultado" => $_SESSION['resultado'],
                "cartas" => implode(',', $_SESSION['cartas']),
                "intentos" => $_SESSION['intentos']
            ];
            guardarArrayAsociativoCSV($archivo, $resultado);
            
            header("Location: resultado.php", true, 302);
            exit();
        } elseif ($_SESSION['puntuacion_actual'] === 21) {
            $_SESSION['resultado'] = "ganó";
            $_SESSION['juego_terminado'] = true;
            
            $resultado = [
                "usuario" => $_SESSION['usuario'],
                "puntuacion" => $_SESSION['puntuacion_actual'],
                "resultado" => $_SESSION['resultado'],
                "cartas" => implode(',', $_SESSION['cartas']),
                "intentos" => $_SESSION['intentos']
            ];
            guardarArrayAsociativoCSV($archivo, $resultado);
            
            header("Location: resultado.php", true, 302);
            exit();
        } else {
            header("Location: juego.php", true, 302);
            exit();
        }
    }

    if ($accion === "plantarse") {
        $_SESSION['juego_terminado'] = true;
        $_SESSION['resultado'] = "plantado";
        
        $resultado = [
            "usuario" => $_SESSION['usuario'],
            "puntuacion" => $_SESSION['puntuacion_actual'],
            "resultado" => $_SESSION['resultado'],
            "cartas" => implode(',', $_SESSION['cartas']),
            "intentos" => $_SESSION['intentos']
        ];
        guardarArrayAsociativoCSV($archivo, $resultado);
        
        header("Location: resultado.php", true, 302);
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Procesando Jugada</title>
    <link rel="stylesheet" href="https://cdn.simplecss.org/simple.min.css">
</head>
<body>
    <h1>Procesando tu jugada...</h1>
    <p>Por favor espera mientras procesamos tu movimiento.</p>
</body>
</html>