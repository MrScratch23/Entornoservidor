<?php
// ¡AQUÍ session_start() y require_once 'dataset.php';!
// require necesita ir primero
session_start();
require_once 'dataset.php';
$html = "";

$contadorID = 0;
$reservados = [];





foreach ($viajes as $viaje) {
    $contadorID++;
    $html .= "<article class='trip-card'>
            <div class='trip-img'>
                <img src='{$viaje['imagen']}' alt='Foto de {$viaje['destino']}'>
            </div>
            <div class='trip-info'>
                <h2>{$viaje['destino']}</h2>
                <span class='meta'>{$viaje['duracion']} días | {$viaje['pais']}</span>
                <p>Valoración: ⭐ {$viaje['valoracion']}/5</p>
            </div>
            <div class='trip-action'>
                <span class='price'>{$viaje['precio']}€</span>
                <a href='stats.php?id={$contadorID}' class='btn-select'>Ver Análisis</a>
            </div>
        </article>";
}







?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agencia de Viajes - Catálogo</title>
    <link rel="stylesheet" href="estilos.css">
</head>

<body>
    <header>
        <h1>Destinos Disponibles</h1>
        <p>Selecciona un viaje para ver las estadísticas comparativas.</p>

        <div class="counter">
            Viajes reservados: <?php
            echo count($reservados);
            ?>
        </div>
    </header>
    <div class='mensaje-flash'><?php
    if (isset($_SESSION['mensajeflash'])) {
        echo $_SESSION['mensajeflash'];
        unset($_SESSION['mensajeflash']);
    }

    ?></div> 
    <main class="travel-grid">
     <?php
     echo $html;
     
     ?>

    </main>
</body>

</html>