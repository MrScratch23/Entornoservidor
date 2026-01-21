
<?php
var_dump($_SESSION['usuario']);

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Monroy Delivery - Gestión de Vehículos</title>
    <link rel="stylesheet" href="css/styles.css">
</head>

<body>
    <!-- Cabecera Común -->
    <header class="main-header">
        <div class="header-container">
            <div class="header-logo">
                <h1>🚚 Monroy Delivery</h1>
            </div>
            <!-- Actualizar los enlaces del menú -->
            <nav class="main-nav">
                <a href="" class="nav-link active">Vehículos</a>
                <a href="#" class="nav-link">-- sustituir enlace --</a>
            </nav>
            <!-- información del usuario -->
            <div class="header-user">
                <div>
                    <span>-- sustituir información --</span>
                </div>
                <a href="logout" class="btn-logout">🚪 Salir</a>
            </div>
        </div>
    </header>

    <!-- Contenido Principal -->
    <main class="main-content">
       <div class="content-container">
            <?php if (!empty($_SESSION['mensajeExito']) || (!empty($_SESSION['mensajeError']))) : ?>
            <div class="flash-message success">
                <?php
                if (!empty($_SESSION['mensajeExito'])) {
                    echo $_SESSION['mensajeExito'];
                    unset($_SESSION['mensajeExito']);
                }
                if (!empty($_SESSION['mensajeError'])) {
                    echo $_SESSION['mensajeError'];
                    unset($_SESSION['mensajeError']);
                }
                ?>
            </div>
            <?php endif; ?>



            <section class="page-header">
                <h2>-- Vehículos: sustituir título --</h2>
                <p class="page-description">-- sustituir texto --</p>
            </section>

            <!-- Grid de Vehículos -->
            <section class="vehicles-grid">
                <!-- Mostrar cuando no hay vehículos -->
                 <?php if (count($vehiculos) === 0) :?>
                <h1>No hay vehículos disponibles</h1>
                <?php endif; ?> 
                
                <!-- Card Vehículo 1 -->
                 <?php foreach ($vehiculos as $vehiculo): ?>
                <article class="vehicle-card">
                    <div class="vehicle-image">
                        <img src="./img/vehiculos/<?php echo $vehiculo['imagen'] ?>" alt="nombre del vehículo">
                        <?php if ($vehiculo['estado'] === 'Disponible'): ?>
                        <span class="vehicle-status status-available">Disponible</span>
                        <?php endif; ?>
                        <?php if ($vehiculo['estado'] === 'En Ruta'): ?>
                        <span class="vehicle-status status-busy">En Ruta</span>
                        <?php endif; ?>
                         <?php if ($vehiculo['estado'] === 'Mantenimiento'): ?>
                         <span class="vehicle-status status-maintenance">Mantenimiento</span>
                         <?php endif; ?>
                    </div>
                    <div class="vehicle-info">
                        <h3 class="vehicle-name"><?php echo $vehiculo['nombre'] ?></h3>
                        <p class="vehicle-plate">🚗 Matrícula: <strong><?php echo $vehiculo['matricula'] ?></strong></p>
                        <div class="vehicle-specs">
                            <div class="spec-item">
                                <span class="spec-icon">⚖️</span>
                                <div class="spec-content">
                                    <span class="spec-label">Carga Máx: </span>
                                    <span class="spec-value"><?php echo $vehiculo['carga_maxima'] ?></span>
                                </div>
                            </div>
                            <div class="spec-item">
                                <span class="spec-icon">📦</span>
                                <div class="spec-content">
                                    <span class="spec-label">Volumen Máx:</span>
                                    <span class="spec-value"><?php echo $vehiculo['volumen_maximo'] ?></span>
                                </div>
                            </div>
                            <div class="spec-item">
                                <span class="spec-icon">⛽</span>
                                <div class="spec-content">
                                    <span class="spec-label">Combustible:</span>
                                    <span class="spec-value"><?php echo $vehiculo['combustible'] ?></span>
                                </div>
                            </div>
                            <div class="spec-item">
                                <span class="spec-icon">🛣️</span>
                                <div class="spec-content">
                                    <span class="spec-label">Kilometraje:</span>
                                    <span class="spec-value"><?php echo $vehiculo['km'] ?></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- acciones del vehículo -->
                    <div class="vehicle-actions">
                        <form action="#" method="POST">
                            <button type="submit" class="btn btn-primary btn-block">
                                📋 -- Ficha Técnica --
                            </button>
                        </form>
                    </div>
                </article>
                <?php endforeach; ?>
               

            </section>
        </div>
    </main>
    <!-- Pie de Página Común -->
    <footer class="main-footer">
        <div class="footer-container">
            <p>&copy; 2025 Monroy Delivery - by P.Lluyot</p>
        </div>
    </footer>
</body>

</html>