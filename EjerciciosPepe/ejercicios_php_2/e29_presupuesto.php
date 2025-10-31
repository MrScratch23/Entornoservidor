<?php
######## DECLARACION
//inicializamos variables
$mensaje = "";
$error = false;

//declaramos el array de datos
$destinos = [
    "roma" => ["ciudad" => "Roma", "pais" => "Italia", "precio_dia" => 100],
    "paris" => ["ciudad" => "París", "pais" => "Francia", "precio_dia" => 120],
    "lisboa" => ["ciudad" => "Lisboa", "pais" => "Portugal", "precio_dia" => 90],
    "berlin" => ["ciudad" => "Berlín", "pais" => "Alemania", "precio_dia" => 110]
];

######## FUNCIONES
//función que realiza el cálculo del total de un viaje
function calcularTotal($precio_dia, $personas, $dias)
{
    $total =  $precio_dia  * $personas * $dias;
    if ($dias >= 7) $total *= 0.9;
    return $total;
}
//función que muestra un mensaje con toda la información del viaje
function generarMensaje($ciudad, $pais, $precio, $personas, $dias, $total){
    $mensaje =  "Presupuesto para viajar a $ciudad ($pais)<br>";
    $mensaje .= "Precio por persona/día: $precio €<br>";
    $mensaje .= "Personas: $personas | Días: $dias<br>";
    $mensaje .= "Total estimado: ".number_format($total, 2)." €<br>";
    if ($total > 3000)
        $mensaje .= "💡 Recomendación: Revisa si puedes reducir días o personas.";
    elseif ($total < 1000)
        $mensaje .= "👍 ¡Es un viaje económico!";
    else
        $mensaje .= "✔️ Precio razonable.";
    return $mensaje;
}

######## LOGICA DE LA APLICACION
//recuperamos los parámetros de la URL y validamos.
$destino = $_GET['destino'] ?? "";
$personas = $_GET['personas'] ?? null;
$dias = $_GET['dias'] ?? null;

## VALIDACIONES
//validamos que vienen todos los parámetros
if (empty($destino) || !isset($personas) || !isset($dias)) {
    $mensaje = "Parámetros insuficientes";
    $error = true;
} //comprobamos si el destino es correcto 
elseif (array_key_exists($destino, $destinos) == false) {
    $mensaje = "El destino no existe";
    $error = true;
} //comprobamos que los parámetros día y personas son positivos
elseif (intval($personas) <=0 || intval($dias) <= 0) {
    $mensaje = "Personas y Días deben ser números positivos";
    $error = true;
} //validamos que el dia y persona son numeros enteros
elseif(intval($personas)!=$personas || intval($dias)!=$dias){
    $mensaje = "Personas y Días deben ser números enteros";
    $error = true;
}

if (!$error) {
    //llamar una función que calcule el precio
    //recuperamos del array los datos del viaje
    $viaje = $destinos[$destino];
    $precio_dia = $viaje['precio_dia'];
    //llamamos a la función calculatTotal para almacenar el precio del viaje
    $total =  calcularTotal($precio_dia, $personas, $dias);
    //generamos el mensaje a mostrar a través de la función generarMensaje
    $mensaje = generarMensaje($viaje['ciudad'], $viaje['pais'], $precio_dia, $personas, $dias, $total);
   
}
?>
<!DOCTYPE html>
<html lang='es'>

<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>P.Lluyot</title>
    <link rel='stylesheet' href='https://cdn.simplecss.org/simple.min.css'>
</head>

<body>
    <header>
        <h2>Viajes</h2>
    </header>
    <main>
        <!-- código php -->
        <?php

        ?>
        <?php if (!empty($mensaje)) echo "<p class='notice'>$mensaje</p>"; ?>
        <p>Enlaces de prueba:</p>
        <a href="http://localhost/php/php_2/e29_presupuesto.php?destino=roma&personas=3&dias=5">Prueba1</a><br>
        <a href="http://localhost/php/php_2/e29_presupuesto.php?destino=paris&personas=2&dias=8">Prueba2</a><br>
        <a href="http://localhost/php/php_2/e29_presupuesto.php?destino=lisboa&personas=4&dias=3">Prueba3</a><br>
    </main>
    <footer>
        <p>P.Lluyot</p>
    </footer>
</body>

</html>