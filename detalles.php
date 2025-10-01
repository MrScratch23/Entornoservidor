
<?php

include 'datos_estudiantes.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php
   if (isset($_GET['nombre'])) {
    $nombreEstudiante = $_GET['nombre']; 
    $notasEstudiante = $estudiantes[$nombreEstudiante];
   

$promedio = array_sum($notasEstudiante) / count($notasEstudiante);
         echo "<h3>Notas de $nombreEstudiante</h3>";
        echo "<ul>";
       
        foreach ($notasEstudiante as $materia => $nota) {
            echo "<li> Materia: $materia Nota: $nota</li>";
}
        echo    "</ul>";
     echo '<a href="index.php">Volver</a>';
        
    } else {
        $sumaTotal = 0;
        $totalAsignaturas = 0;
            foreach ($estudiantes as $estudiante => $notas) {
                    foreach ($notas as $materia => $nota) {
                        $sumaTotal += $nota;
                        $totalAsignaturas++;

                    
                    }

                     
            }
            $promedioGeneral = $sumaTotal / $totalAsignaturas;
    echo '<p>La media general de todos los estudiantes es: ' . $promedioGeneral . '</p>';
    echo '<a href="indexestudiantes.php">Volver</a>';
  
       
     
    }
    
    
    ?>
    
</body>
</html>