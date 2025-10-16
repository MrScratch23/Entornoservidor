
<?php

$grados = $_GET['grados'] ?? '';
$mensaje = "";

// funcionees 

function convertir_grados($grados) {
    $grados_convertidos = ($grados * 9 / 5) + 32;
    return $grados_convertidos;
}

function eliminar_grados (&$grados) {
    $grados = 0;
}


if ($grados === "") {
    $mensaje .= "Debes introducir un valor";
} elseif (!is_numeric($grados)) {
    $mensaje .= "Debes introducir un número";
} else {
    // convertimos los grados
    $grados_convertidos = convertir_grados($grados);
    $mensaje .= "<p>Los grados Celsius: $grados convertidos son $grados_convertidos °F</p>";
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
  <h1>Convertir grados Celsius a Fahrenheit</h1>

    <form method="GET" action="<?= htmlspecialchars($_SERVER['PHP_SELF']) ?>">
    <label for="grados">Grados (Celsius):</label>
    <input type="number" name="grados" id="grados" value="<?= htmlspecialchars($grados) ?>" placeholder="Introduce la temperatura" required />
    <br><br>
    <button type="submit">Convertir</button>
    <input type="reset" value="Limpiar"></button>
</form>
<?= $mensaje ?>



</body>

</html>