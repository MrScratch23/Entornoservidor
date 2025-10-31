<?php
//código php
include 'e30_datos_estudiantes.php';

$nombre = $_GET['nombre'] ?? null;
// es equivalente a:
// if (isset($_GET['nombre'])) {
//     $nombre = $_GET['nombre'];
// } else {
//     $nombre = null;
// }
if ($nombre && isset($estudiantes[$nombre])) {
    $notas = $estudiantes[$nombre]; // Obtener las notas del estudiante
    // Calcular el promedio
    $promedio = array_sum($notas) / count($notas);
    //echo "<h1>Promedio de $nombre: " . number_format($promedio, 2) . "</h1>";
} else { // Mostrar el promedio general de la clase
    $total = 0;
    $cantidad = 0;
    foreach ($estudiantes as $notas) {
        $total += array_sum($notas);
        $cantidad += count($notas);
    }
    unset($notas); // Asegurarse de que $notas no esté definido
    $promedioGeneral = $total / $cantidad;
   //echo "<h1>Promedio general de la clase: " . number_format($promedioGeneral, 2) . "</h1>";
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
        <h2>Información de estudiantes</h2>
    </header>
    <main>
        <!-- código php -->
        <?php
        //si se ha proporcionado un nombre de estudiante
        if (isset($notas)){
            echo "<h3>Notas de $nombre:</h3>";
            echo "<ul>";
            foreach ($notas as $asignatura => $nota) {
                echo "<li>" . htmlspecialchars($asignatura) . ": " . htmlspecialchars($nota) . "</li>";
            }
            echo "</ul>";
        }
        //mostrar el promedio correspondiente
        if(isset($promedio)) {
            echo "<p>Promedio de $nombre: " . number_format($promedio, 2) . "</p>";
        } elseif (isset($promedioGeneral)) {
            echo "<p>Promedio general de la clase: " . number_format($promedioGeneral, 2) . "</p>";
        } else {
            echo "<p>Error genérico.</p>";
        }
        ?>
        <a href="e30_index.php">Volver al listado de estudiantes</a>
        

        <!-- <p class='notice'></p> -->
    </main>
    <footer>
        <p>P.Lluyot</p>
    </footer>
</body>

</html>