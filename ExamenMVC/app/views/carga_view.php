

<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alcalá Delivery - Gestión de Carga</title>
    <link rel="stylesheet" href="<?= BASE_URL ?>css/styles.css">
</head>

<body>
    <!-- Cabecera Común -->
    <header class="main-header">
        <div class="header-container">
            <div class="header-logo">
                <h1>🚚 Alcalá Delivery</h1>
            </div>

            <nav class="main-nav">
                <a href="/" class="nav-link">Vehículos</a>
                <a href="carga" class="nav-link active">Gestión de Carga</a>
            </nav>

            <div class="header-user">
                <div class="user-info">
                    <span class="user-name">👤 <?php echo '' . $_SESSION['usuario']['nombre'] . ' ' . $_SESSION['usuario']['apellidos'] . '' ?></span>
                    <span class="user-role"><?php echo $_SESSION['usuario']['rol'] ?></span>
                </div>
                <a href="logout" class="btn-logout">🚪 Salir</a>
            </div>
        </div>
    </header>

    <!-- Contenido Principal -->
    <main class="main-content">
        <div class="content-container">
            <!-- Mensaje Flash -->

            <section class="page-header">
                <h2>Gestión de Carga</h2>
                <p class="page-description">Optimice la carga del vehículo seleccionado</p>
            </section>

            <!-- Información del Vehículo Seleccionado -->
             <?php if (isset($vehiculo)): ?>
            <section class="selected-vehicle-info">
                <div class="vehicle-summary">
                    <div class="summary-item">
                        <span class="summary-icon">🚚</span>
                        <div>
                            <span class="summary-label">Vehículo: </span>
                            <span class="summary-value"><?php echo htmlspecialchars($vehiculo[0]['nombre']) ?></span>
                        </div>
                    </div>
                    <div class="summary-item">
                        <span class="summary-icon">⚖️</span>
                        <div>
                            <span class="summary-label">Carga (Actual / Máxima):</span>
                            <span class="summary-value">
                            <?php if (isset($cargaMaxima)) {
                                echo $cargaMaxima;
                            } else {
                                echo "0";
                            }
                            ?>    
                             / <?php echo $vehiculo[0]['carga_maxima'] ?> kg</span>
                        </div>
                    </div>
                    <div class="summary-item">
                        <span class="summary-icon">📦</span>
                        <div>
                            <span class="summary-label">Volumen (Actual / Máximo):</span>
                            <span class="summary-value">  <?php if (isset($volumen)) {
                                echo $volumen;
                            } else {
                                echo "0";
                            }
                            ?>  / <?php echo $vehiculo[0]['volumen_maximo'] ?> m³</span>
                        </div>
                    </div>
                </div>
            </section>
                      
            <!-- Botones de Acción -->
            <section class="action-buttons">
                <form action="carga" method="POST">
                    <button type="submit" class="btn btn-secondary">
                        🔄 Calcular Carga Óptima
                    </button>
                </form>
                <form action="confirmar" method="POST">
                    <?php if (!empty($paquetesAceptados)) : ?>
                    <button type="submit" class="btn btn-primary">
                        <?php endif; ?>    

                    <button type="submit" class="btn btn-primary" disabled="">
                        ✅ Confirmar Envío
                    </button>
                </form>
            </section>
        <?php endif; ?>     
            <!-- Tabla de Paquetes -->
            
            <section class="packages-section">
                <h3 class="section-title">Paquetes Pendientes</h3>
               
                <div class="table-responsive">
                   
                    <table class="packages-table">
                        
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Destino</th>
                                <th>Peso (kg)</th>
                                <th>Volumen (m³)</th>
                                <th>Prioridad</th>
                                <th>Estado</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="package-pending">
                                 <?php foreach ($paquetes as $paquete): ?>
                                <td><?php echo $paquete['id'] ?></td>
                                <td><?php echo $paquete['destino'] ?></td>
                                <td><?php echo $paquete['peso'] ?> </td>
                                <td><?php echo $paquete['volumen'] ?></td>
                                <?php if ($paquete['prioridad'] === "Alta"): ?>
                                <td><span class="priority priority-high">Alta</span></td>
                                <?php endif ?>
                                <?php if ($paquete['prioridad'] === "Media"): ?>
                                <td><span class="status-badge status-pending">Pendiente</span></td>
                                 <?php endif ?>
                                 <?php if ($paquete['prioridad'] === "Baja"): ?>
                                    <td><span class="priority priority-low">Baja</span></td>
                                <?php endif; ?>   
                                 <td><span class="status-badge status-pending"><?php echo $paquete['estado'] ?></span></td>
                            </tr>
                               <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </section>
        
        </div>
         
    </main>
    

    <!-- Pie de Página Común -->
    <footer class="main-footer">
        <div class="footer-container">
            <p>© 2025 Monroy Delivery - by P.Lluyot</p>
        </div>
    </footer>


</body>

</html>