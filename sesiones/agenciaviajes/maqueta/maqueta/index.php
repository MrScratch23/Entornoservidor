<?php
// ¡AQUÍ session_start() y require_once 'dataset.php';!

session_start();
require_once "dataset.php";
$contadorID = 0;



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
            Viajes reservados: <?php  echo isset($_SESSION['reservas']) ? count($_SESSION['reservas']) : 0;  ?>
        </div>
    </header>
   <div class='mensaje-flash'>      <?php
        if (isset($_SESSION['mensajeflash'])) {
            echo $_SESSION['mensajeflash'];
            unset($_SESSION['mensajeflash']);
        }
        ?></div>
<main class="travel-grid">
    <?php foreach ($viajes as $viaje): ?>
    <?php 
        $contadorID++;
        // Verificar si este viaje está reservado
        $claseTarjeta = "trip-card";
        $estaReservado = isset($_SESSION['reservas']) && in_array($contadorID, $_SESSION['reservas']);
        
        if (isset($_SESSION['viajes_vistos']) && in_array($contadorID, $_SESSION['viajes_vistos'])) {
            $claseTarjeta = "trip-card visited";
        }
        if ($estaReservado) {
            $claseTarjeta .= " reserved";
        }
    ?>
    <article class="<?php echo $claseTarjeta; ?>">
        <div class="trip-img">
            <img src="<?php echo $viaje['imagen'] ?>" alt="Foto de <?php echo $viaje['destino'] ?>">
        </div>
        <div class="trip-info">
            <h2><?php echo $viaje['destino']?></h2>
            <span class="meta"><?php echo $viaje['duracion'] ?> días | <?php echo $viaje['pais'] ?></span>
            <p>Valoración: ⭐ <?php echo $viaje['valoracion'] ?></p>
            
            <?php if ($estaReservado): ?>
                <div class="reserva-info">✓ Reservado</div>
            <?php endif; ?>
        </div>
        <div class="trip-action">
            <span class="price"><?php echo $viaje['precio'] ?> $</span>
            <a href="stats.php?id=<?php echo $contadorID; ?>" class="btn-select">Ver Análisis</a>
            
                <?php if (!$estaReservado): ?>
                <a href="reservar.php?id=<?php echo $contadorID; ?>" class="btn-select">
                    Añadir a Reservas
                </a>
                <?php else: ?>
                <a href="eliminar.php?id=<?php echo $contadorID; ?>" class="btn-select">
                    Eliminar Reserva
                </a>
                <?php endif; ?>
        </div>
    </article>
    <?php endforeach; ?>
</main>
</body>

</html>