<?php
#DECLARACION DE VARIABLES
$mensaje = "";
$error = false;
#FUNCIONES
// calcula la nota media de un array de números
function calcularMedia($array)
{
    $suma = array_sum($array);
    $num_elementos = count($array);
    return $suma / $num_elementos;
}

#RECUPERAMOS LAS NOTAS
$notas = $_GET['notas'] ?? null;
//si no recibinos las notas almacenamos el mensaje de error.
if (!isset($notas)) {
    $error = true;
    $mensaje = "No se han recibido las notas";
}

#VALIDACIÓN
if (!$error) {
    //transformamos la cadena en un array ($a_notas)
    $a_notas = explode(",", $notas);
    //recorremos el array para validar los datos
    foreach ($a_notas as $nota) {
        //comprobamos si es un valor numérico entre 0 y 10 (en otro caso generar mensaje y salir)
        if ($nota != floatval($nota)) { //podemos usar is_numeric()
            $error = true;
            $mensaje = "Error en los valores de los parámetros";
            break;
        } elseif ($nota < 0 || $nota > 10) {
            $error = true;
            $mensaje = "las notas deben estar comprendidas entre 0 y 10";
            break;
        }
    }
}
// si no hay error calculamos la nota media
if (!$error) {
    $media = calcularMedia($a_notas);
    $num_suspensos = count(array_filter($a_notas, function($nota){
        return $nota<5;
    }));
    $num_aprobados = count($a_notas) - $num_suspensos;

    $mensaje = "Media de las notas: " . number_format($media, 2) . "<br>";
    $mensaje .= ($media < 5 ? "El grupo ha suspendido.<br>" : "El grupo ha aprobado<br>");
    $mensaje .= "Notas aprobadas: $num_aprobados<br>";
    $mensaje .= "Notas suspendidas: $num_suspensos<br>";
}
#

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
        <h2>Notas de alumnos</h2>
    </header>
    <main>
        <!-- código php -->
        <?php

        ?>
        <h3>Test</h3>
        <ul>
            <li><a href="http://localhost/php/php_2/e16_notas_modificado.php?notas=5,8,4.5">http://localhost/php/php_2/e16_notas_modificado.php?notas=5,8,4.5</a></li>
            <li><a href="http://localhost/php/php_2/e16_notas_modificado.php?notas=1,2,5,8,4.5">http://localhost/php/php_2/e16_notas_modificado.php?notas=1,2,5,8,4.5</a></li>
            <li><a href="http://localhost/php/php_2/e16_notas_modificado.php">http://localhost/php/php_2/e16_notas_modificado.php</a></li>
            <li><a href="http://localhost/php/php_2/e16_notas_modificado.php?notas=-1,5">http://localhost/php/php_2/e16_notas_modificado.php?notas=-1,5</a></li>
            <li><a href="http://localhost/php/php_2/e16_notas_modificado.php?notas=asdasd">http://localhost/php/php_2/e16_notas_modificado.php?notas=asdasd</a></li>
        </ul>
        <p class='notice'><?= $mensaje; ?></p>
    </main>
    <footer>
        <p>P.Lluyot</p>
    </footer>
</body>

</html>