<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notas de Estudiantes</title>
    <link rel="stylesheet" href="https://cdn.simplecss.org/simple.min.css">
</head>
<body>

<?php

$contador_aprobado = 0;

$estudiantes = array(
    "Rubén" => 9.4,
    "Luisa" => 6.7,
    "Javier" => 4.2,
    "Luis" => 5.3
);

// Inicializamos la nota más alta y baja
$nota_alta = max($estudiantes);
$nota_baja = min($estudiantes);

echo "<table>
    <tr>
        <th>Estudiante</th>
        <th>Nota</th>
        <th>Resultado</th>
    </tr>";

foreach ($estudiantes as $nombre => $nota) {
    $resultado = ($nota >= 5) ? "Aprobado" : "Suspenso";

    if ($nota >= 5) {
        $contador_aprobado++;
    }

    echo "<tr>
            <td>$nombre</td>
            <td>$nota</td>
            <td>$resultado</td>
        </tr>";
}

echo "</table>";

echo "<p><strong>Estudiantes aprobados:</strong> $contador_aprobado</p>";
echo "<p><strong>Nota más alta:</strong> $nota_alta</p>";
echo "<p><strong>Nota más baja:</strong> $nota_baja</p>";

?>

</body>
</html>
