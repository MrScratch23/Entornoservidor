<?php
// ¡Aquí va toda la lógica de validación, cálculos y gestión de $_SESSION['vistos']!

session_start();
require_once 'dataset.php';


$id = $_GET['id'] ?? '';


// comprobar que se pasan parametros correctos
if ($id === '' || !isset($viajes[$id])) {
    header("Location: index.php", true, 302);
    exit();
}

$_SESSION['viajes_vistos'] = $id;
// obtener los datos del viaje
$viaje = $viajes[$id];

$sumaTotal = 0;
$sumaTotalDias = 0;

foreach ($viajes as $v) {
    $sumaTotal += $v['precio'];
    $sumaTotalDias += $v['duracion'];
}

$media = $sumaTotal / count($viajes);

$maximo = max(array_column($viajes, 'precio'));
$porcentaje = $viaje['precio'] / $maximo;

$mediaDias = $sumaTotalDias / count($viajes);

$maximo = max(array_column($viajes, 'duracion'));
$porcentaje = $viaje['duracion'] / $maximo;


$html = "<section class='detail-card'>
            <h1>{$viaje['destino']}</h1>
            <div class='data-row'>
                <span>📅 {$viaje['duracion']}</span>
                <span>🌍 {$viaje['destino']}</span>
                <span>⭐ {$viaje['valoracion']}</span>
            </div>
            <div class='big-price'>{$viaje['precio']} $</div>

            <a href='reservar.php?id=$id' class='btn-reserve'>Reservar este viaje</a>
        </section> "

if ($viaje['precio'] > $media) {
   $clasePrecio = "";
}




?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Análisis del Viaje</title>
    <link rel="stylesheet" href="estilos.css">
</head>

<body>



    <div class="container">
        <a href="index.php" class="back-link">← Volver al listado</a>

        <?php
        echo $html;
        ?>

        <section class="detail-card stats-section">
            <h2>Comparativa con la Media del Catálogo</h2>

            <div class="stat-item">
                <div class="stat-label">
                    <span>Precio del viaje: <?php
                    echo $viaje['precio']?></span>
                    <small>Media del catálogo: <?php
                    echo number_format($media, 2);
                    ?></small>
                </div>
                <div class="bar-container">
                    <div class="bar-fill"  style=<?php echo 'width' . $porcentaje ; ?>></div>
                    
                </div>
            </div>

            <div class="stat-item">
                <div class="stat-label">
                    <span>Duración: <?php
                    echo $viaje['duracion'];
                    ?> dias</span>
                    <small>Media del catálogo: <?php
                    echo $mediaDias
                    ?> días</small>
                </div>
                <div class="bar-container">
                    <div class="bar-fill" style=<?php echo 'width' . $mediaDias ?>></div>
                </div>
            </div>

        </section>
    </div>

</body>

</html>