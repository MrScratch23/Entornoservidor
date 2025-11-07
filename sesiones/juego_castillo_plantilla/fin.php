<?php

session_start();

// volvemos a recuperar los datos 

if (!isset($_SESSION['usuario'])) {
    header("Location:index.php", true, 302);
    exit();
}



    $puntos=  $_SESSION['puntos'];
    $aciertos= $_SESSION['aciertos'];
    $fallos= $_SESSION['fallos'];
    $turnos = $_SESSION['turnos'];
    $usuario = $_SESSION['usuario'];
    $mensaje = "";
    $archivoFichero = "registro.txt";

    if ($turnos<5) {
        header("Location:index.php", true, 302);
        exit();
    }

       
    $usuarioRegistro = [$usuario, $puntos, $aciertos, date('Y-m-d')];


    if (!file_exists($archivoFichero)) {
        file_put_contents($archivoFichero, implode("-", $usuarioRegistro));;
    } else {
        file_put_contents($archivoFichero, "|" . implode("-", $usuarioRegistro), FILE_APPEND);
        $mensaje = "Fichero creado correctamente.";
    }

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['reiniciar'])) {

    session_unset();
    session_destroy();
    header("Location:index.php", true, 302);
    exit();
}


?>
<!DOCTYPE html>
<html lang='es'>

<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>

    <head>
        <meta charset="UTF-8">
        <title>Guardia del Castillo</title>
        <link rel='stylesheet' href='css/estilos.css'>
    </head>

<body>
    <h1>Guardia del Castillo</h1>
    <main>
        <p>Gracias por jugar, <?php
        echo $usuario
        ?>.</p>
        <p>Has conseguido un total de <?php
        echo $puntos;
        ?>.</p>
        <p>Has acertado <?php
        echo $aciertos;
        ?> y fallado <?php
        echo $fallos;
        ?>.</p>
        <form method="post" action="fin.php">
            <button type="submit" name="reiniciar">Jugar de nuevo</button>
        </form>

        <p class="ok"><?php
        echo $mensaje;
        ?>.</p>
    </main>
</body>

</html>