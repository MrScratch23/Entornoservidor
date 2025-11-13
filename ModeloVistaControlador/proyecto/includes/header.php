<?php


?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title><?php
    echo $pagina;
    ?></title>
    <link rel="stylesheet" href="css/estilos.css">
</head>
<body>
    <header class="site-header">
        <h1>Portal Modular</h1>
        <nav>
            <!-- CÓDIGO REPETIDO -->
            <ul>
                <li><a href="index.php?p=inicio">Inicio</a></li>
                <li><a href="index.php?p=nosotros">Nosotros</a></li>
                <li><a href="index.php?p=contacto">Contacto</a></li>
            </ul>
        </nav>
    </header>
<main class="contenedor-principal">
    <?php
    if (!empty($mensaje)) {
        echo "<h3>$mensaje</h3>";
    } else {
        echo "<h3> Aun no existe mensaje.";
    }
    ?>

