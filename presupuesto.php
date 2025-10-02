<?php
$destinos = [
    "roma" => ["ciudad" => "Roma", "pais" => "Italia", "precio_dia" => 100],
    "paris" => ["ciudad" => "París", "pais" => "Francia", "precio_dia" => 120],
    "lisboa" => ["ciudad" => "Lisboa", "pais" => "Portugal", "precio_dia" => 90],
    "berlin" => ["ciudad" => "Berlín", "pais" => "Alemania", "precio_dia" => 110]
];
// validamos si existe

$error = "";
if (!isset($_GET['destino'])) {
    $error = "No colocaste ningún destino.";
} elseif (!isset($_GET['personas']) || !isset($_GET['dias']) || $_GET['personas'] <= 0 || $_GET['dias'] <= 0) {
    $error = "Debes ingresar un número válido de personas y días (mayores que 0).";
} else {
    // guardamos todo si existe
    $destino = $_GET['destino'];
    $personas = (int) $_GET['personas'];
    $dias = (int) $_GET['dias'];
    
     
    
    if (!isset($destinos[$destino])) {
        $error = "Destino no válido.";
        exit;
    }



    $datos_destino = $destinos[$destino];
    // con total  y mensaje recuperamos la suma_total_viaje y el mensaje del return
    [$total, $mensaje] = calcularTotal($datos_destino['precio_dia'], $personas, $dias);
        // usamos la funcion ya al final para mostrar
    mostrarPresupuesto($destino, $personas, $dias, $datos_destino, $total, $mensaje);
}

function calcularTotal($precio_dia, $personas, $dias) {
    $suma_total_viaje = $precio_dia * $personas * $dias;

    if ($dias > 7) {
        $descuento = $suma_total_viaje * 0.10;
        $suma_total_viaje -= $descuento;
    }

    // calculo
    if ($suma_total_viaje > 3000) {
        $mensaje = "Mayor a 3000€: 💡 Recomendación: Revisa si puedes reducir días o personas.";
    } elseif ($suma_total_viaje < 1000) {
        $mensaje = "Menor a 1000€: 👍 ¡Es un viaje económico!";
    } else {
        $mensaje = "Entre 1000€ y 3000€: ✔️ Precio razonable.";
    }
    // con return las variables de la misma funcion las podemos sacar para usarlas
    return [$suma_total_viaje, $mensaje];
}

function mostrarPresupuesto($destino, $personas, $dias, $datos, $suma_total_viaje, $mensaje) {
    echo "<h2>Presupuesto para viajar a {$datos['ciudad']} ({$datos['pais']})</h2>";
    echo "<p>Precio por persona/día: {$datos['precio_dia']} €</p>";
    echo "<p>Personas: $personas | Días: $dias</p>";
    echo "<p><strong>Total estimado: $suma_total_viaje €</strong></p>";
    echo "<p>$mensaje</p>";
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdn.simplecss.org/simple.min.css">
</head>
<body>
<p>Enlaces de prueba</p>
<?php
echo '<a href="presupuesto.php?destino=paris&personas=2&dias=8">Prueba 1 (París - 2 personas, 8 días)</a><br>';
echo '<a href="presupuesto.php?destino=roma&personas=3&dias=5">Prueba 2 (Roma - 3 personas, 5 días)</a><br>';
echo '<a href="presupuesto.php?destino=lisboa&personas=4&dias=3">Prueba 3 (Lisboa - 4 personas, 3 días)</a><br>';
if ($error !== "") {
    // colores y mensaje de error añadido por gpt para que quede en condiciones
    echo "<p style='color: red; font-weight: bold;'>$error</p>";
}
?>





   
</body>
</html>