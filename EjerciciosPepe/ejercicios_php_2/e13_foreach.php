<?php
/**
 * Ejercicio realizado por P.Lluyot. 2DAW
 */
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
        <!-- código php -->
        <?php
        //almacenamos los estudiantes en un array asociativo
        //donde el índice es el nombre del estudiante y la nota el valor.
        $estudiantes = array(
            "Pepe" => 8.23,
            "Juan" => 4.34,
            "Ana" => 5.66,
            "Elena" => 9.66,
            "Pedro" => 2.14
        );
        //mostramos el contenido en una tabla HTML
        //generamos en primer lugar la cabecera de la tabla.
        echo "<table>
            <tr>
                <th>Estudiante</th>
                <th>Nota</th>
            </tr>";

        //inicializamos las variables min, max y número de aprobados.
        $max = 0;
        $min = 10;
        $aprob = 0;

        //recorremos cada elemento del array asociativo
        foreach ($estudiantes as $nombre => $nota) {
            //comprobamos si la nota supera la nota máxima para almacenarla
            if ($nota > $max)  $max = $nota;

            //comprobamos si la nota supera la nota mínmima para almacenarla
            if ($nota < $min)  $min = $nota;

            //acumulamos las notas que sean superiores o iguales al 5
            if ($nota >= 5) $aprob++;

            //generamos una fila de la tabla con los datos del estudiante
            echo "<tr>
                <td>$nombre</td>
                <td>$nota</td>
              </tr>";
        }
        //fin de la tabla, y lista de aprobados y nota máx y mín.
        echo "</table>";

        //fin
        ?>
        <p class='notice'>
            - Número de aprobados: <?= $aprob; ?><br>
            - La nota máxima es <?= $max; ?><br>
            - La nota mínima es <?= $min; ?><br>
        </p>
    </main>
    <footer>
        <p>P.Lluyot</p>
    </footer>
    </head>

</body>

</html>