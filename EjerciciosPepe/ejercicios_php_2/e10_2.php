<?php
    //código php
    $edades = [18,20,33,21,24,19,17,21];
    $suma_edades = array_sum($edades);
    $num_estudiantes = count($edades);
    
    $edad_media = $suma_edades / $num_estudiantes;
    $mayores = array_filter ($edades, function ($edad){
        return $edad>=18;
    });
    $num_mayores = count($mayores);
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
    <header><h2>Datos edades estudiantes</h2></header>
    <main>
        <!-- código php -->
        <?php
            echo "<h4>Nº estudiantes: $num_estudiantes</h4>";
            echo "<h5>Edad media: $edad_media</h5>";
            echo "<h5>Mayores de edad: $num_mayores</h5>";
        ?>
        <p class='notice'></p>
    </main>
    <footer><p>P.Lluyot</p></footer>
</body>
</html>