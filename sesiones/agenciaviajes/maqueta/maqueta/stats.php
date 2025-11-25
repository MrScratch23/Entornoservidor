<?php
session_start();
require_once 'dataset.php';

$id = $_GET['id'] ?? '';

// comprobar que se pasan parametros correctos
if ($id === '' || !isset($viajes[$id])) {
    header("Location: index.php", true, 302);
    exit();
}

// Inicializar el array si no existe o si es un string
if (!isset($_SESSION['viajes_vistos']) || !is_array($_SESSION['viajes_vistos'])) {
    $_SESSION['viajes_vistos'] = [];
}

// Si por alguna razón es un string, convertirlo a array
if (is_string($_SESSION['viajes_vistos'])) {
    $_SESSION['viajes_vistos'] = [$_SESSION['viajes_vistos']];
}



// Añadir el nuevo ID al array
array_push($_SESSION['viajes_vistos'], $id);

// obtener los datos del viaje
$viaje = $viajes[$id];

$sumaTotal = 0;
$sumaTotalDias = 0;

foreach ($viajes as $v) {
    $sumaTotal += $v['precio'];
    $sumaTotalDias += $v['duracion'];
}

$media = $sumaTotal / count($viajes);
$maximoPrecio = max(array_column($viajes, 'precio'));
$porcentajePrecio = $viaje['precio'] / $maximoPrecio;

$mediaDias = $sumaTotalDias / count($viajes);
$maximoDuracion = max(array_column($viajes, 'duracion'));
$porcentajeDuracion = $viaje['duracion'] / $maximoDuracion;

/* $html = "<section class='detail-card'>
            <h1>{$viaje['destino']}</h1>
            <div class='data-row'>
                <span>📅 {$viaje['duracion']}</span>
                <span>🌍 {$viaje['destino']}</span>
                <span>⭐ {$viaje['valoracion']}</span>
            </div>
            <div class='big-price'>{$viaje['precio']} $</div>
            <a href='reservar.php?id=$id' class='btn-reserve'>Reservar este viaje</a>
        </section>";
*/ 
if ($viaje['precio'] > $media) {
   $clasePrecio = "bar-fill warning";
} else {
    $clasePrecio = "bar-fill";
}

if ($viaje['duracion'] > $mediaDias) {
    $claseDias = "bar-fill warning";
} else {
    $claseDias = "bar-fill";
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
 <header>
        <div class="counter">
            Viajes reservados: <?php 
                echo isset($_SESSION['reservas']) ? count($_SESSION['reservas']) : 0; 
            ?>
        </div>
    </header>



    <div class="container">
        <a href="index.php" class="back-link">← Volver al listado</a>
        <section class='detail-card'>
            <h1><?php echo $viaje['destino'] ?></h1>
            <div class='data-row'>
                <span>📅 <?php echo $viaje['duracion'] ?></span>
                <span>🌍 <?php echo $viaje['destino'] ?></span>
                <span>⭐<?php  echo $viaje['valoracion']?></span>
            </div>
            <div class='big-price'><?php echo $viaje['precio']?> $</div>
            <a href='reservar.php?id=<?php echo $id; ?>' class='btn-reserve'>Reservar este viaje</a>
        </section>
    
        <section class="detail-card stats-section">
            <h2>Comparativa con la Media del Catálogo</h2>
            <div class="stat-item">
                <div class="stat-label">
                    <span>Precio del viaje: <?php echo $viaje['precio']; ?></span>
                    <small>Media del catálogo: <?php echo number_format($media, 2); ?></small>
                </div>
                <div class="bar-container">
                   <div class="<?php echo $clasePrecio; ?>" style="width: <?php echo $porcentajePrecio * 100; ?>%"></div>
                </div>
            </div>
            <div class="stat-item">
                <div class="stat-label">
                    <span>Duración: <?php echo $viaje['duracion']; ?> dias</span>
                    <small>Media del catálogo: <?php echo $mediaDias; ?> días</small>
                </div>
                <div class="bar-container">
                 <div class="<?php echo $claseDias; ?>" style="width: <?php echo $porcentajeDuracion * 100; ?>%"></div>
                </div>
            </div>
        </section>
    </div>
</body>
</html>