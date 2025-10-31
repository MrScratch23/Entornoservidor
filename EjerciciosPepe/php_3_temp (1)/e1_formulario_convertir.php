<?php
/**
 * Ejercicio realizado por P.Lluyot. 2DAW
 */
// Inicializamos las variables
$celsius = "";
$fahrenheit = "";
$mensaje="";

// Verificamos si el formulario ha sido enviado y el campo 'celsius' está definido
//no sería necesario verificar el método pero lo incluyo para que se conozca com oobtenerlo.
if ($_SERVER['REQUEST_METHOD'] == 'GET') { 
    // 1) recogida de y saneado de datos
    $celsius = htmlspecialchars(trim($_GET['celsius'] ?? ""));
    // 2) validación de datos
    if ($celsius === ""){
        $mensaje = "Error al recibir parámetros";
    }elseif(!is_numeric($celsius)){
        $mensaje = "Debes introducir un valor numérico";
    }else{
        //no hay error:
        $celsius = floatval($celsius);
        $fahrenheit = ($celsius * 9 / 5) + 32;
        $mensaje="<h3>Resultado: ".$celsius."°C son ".$fahrenheit." °F</h3>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Conversor de Celsius a Fahrenheit</title>
    <link rel="stylesheet" href="https://cdn.simplecss.org/simple.css">
</head>

<body>
    <header>
        <h2>Conversor de Celsius a Fahrenheit</h2>
    </header>
    <main>
        <!-- Mostrar el resultado si se ha realizado la conversión -->
        <?=$mensaje;?>  
        <p><a href="e1_formulario_get.php">volver</a></p>
    </main>
    <footer>
        <p>P.Lluyot</p>
    </footer>
</body>

</html>