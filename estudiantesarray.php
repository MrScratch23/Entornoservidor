<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>

<?php

$estudiantes = array('Paco', 'Antonio', 'Maria Luisa', 'Sigismundo');

$contador = 0;
$cont_est = 0;

while ($contador < count($estudiantes)) {
    $nombre_estudiante = $estudiantes[$contador];
    

    echo '<p> Nombre del estudiante ' . $estudiantes[$contador] . '</p>';

    if (strlen($nombre_estudiante) > 5) {
        $cont_est++;
        
    }
    
    $contador++;

    

}

echo '<p> El numero total de estudiantes es: ' . count($estudiantes) . '</p>';
echo '<p> El numero total de estudiantes con mas de cinco letras es:  ' . $cont_est . '</p>';



?>
    
</body>
</html>