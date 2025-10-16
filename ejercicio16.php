<?php

$mensaje = "";
$contador_aprobados = 0;
$contador_suspensos = 0;

if (isset($_GET['notas']) && trim($_GET['notas']) !== "") {
    $notas = explode(",", $_GET['notas']);


    foreach ($notas as $nota) {
        if (!is_numeric($nota) || $nota < 0 || $nota > 10) {
            $mensaje = "Error: Las notas deben ser números entre 0 y 10.";
            echo $mensaje;
            exit;
        }
    }

   
    foreach ($notas as $nota) {
        if ($nota >= 5) {
            $contador_aprobados++;
        } else {
            $contador_suspensos++;
        }
    }

    function calcularMedia($notas) {
        return array_sum($notas) / count($notas);
    }

    $media = calcularMedia($notas);

    $mensaje .= "La media del grupo es: " . round($media, 2) . "<br>";

    if ($media >= 5) {
        $mensaje .= "El grupo ha aprobado.<br>";
    } else {
        $mensaje .= "El grupo ha suspendido.<br>";
    }

    $mensaje .= "El número de aprobados es: $contador_aprobados<br>";
    $mensaje .= "El número de suspensos es: $contador_suspensos<br>";

} else {
    $mensaje = "No se introdujo ninguna nota.";
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Resultados de Notas</title>
    <link rel="stylesheet" href="https://cdn.simplecss.org/simple.min.css">
</head>
<body>

    <h2>Resultado del análisis de notas</h2>
    <p><?php echo $mensaje; ?></p>

    <h3>Enlaces de prueba</h3>
    <ul>
        <li><a href="ejercicio16.php?notas=6,7,8,9,5">Notas: 6,7,8,9,5 (Grupo aprobado)</a></li>
        <li><a href="ejercicio16.php?notas=3,4,2,5,1">Notas: 3,4,2,5,1 (Grupo suspendido)</a></li>
        <li><a href="ejercicio16.php?notas=5,5,5,5,5">Notas: 5,5,5,5,5 (Aprobación límite)</a></li>
        <li><a href="ejercicio16.php?notas=10,12,8">Notas: 10,12,8 (Error: nota fuera de rango)</a></li>
        <li><a href="ejercicio16.php">Sin notas (Error: no se introdujo ninguna nota)</a></li>
    </ul>

</body>
</html>
