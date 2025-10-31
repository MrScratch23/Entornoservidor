<?php
/**
 * Ejercicio realizado por P.Lluyot. 2DAW
 */
//almacenamos los estudiantes en un array asociativo
//donde el índice es el nombre del estudiante y la nota el valor.
$estudiantes = array(
    "Pepe" => 8.23,
    "Juan" => 4.34,
    "Ana" => 5.66,
    "Elena" => 9.66,
    "Pedro" => 2.14
);
//obtenemos el número de aprobados
$num_aprobados = count(array_filter($estudiantes, function($nota){
    return $nota>=5;
}));
//obtenemos la nota max y min
$nota_max = max($estudiantes);
$nota_min = min($estudiantes);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel='stylesheet' href='https://cdn.simplecss.org/simple.min.css'>
    <style>
        table {
            margin: 0 auto;
            width: 50%;
            text-align: center;
            /* hace que la tabla ocupe todo el ancho */
        }
    </style>
</head>

<body>
    <header>
        <h2>Info estudiantes</h2>
    </header>
    <main>
        <table>
            <tr>
                <th>Estudiante</th>
                <th>Nota</th>
            </tr>
            <!-- código php -->
            <?php
                foreach($estudiantes as $nombre=>$nota){
                echo "<tr>
                    <td>$nombre</td>
                    <td>$nota</td>
                </tr>";
                };
            ?>
       </table>
        <p class='notice'>
            - Número de aprobados: <?= $num_aprobados; ?><br>
            - La nota máxima es <?= $nota_max; ?><br>
            - La nota mínima es <?= $nota_min; ?><br>
        </p>
    </main>
    <footer>
        <p>P.Lluyot</p>
    </footer>
    </head>

</body>

</html>