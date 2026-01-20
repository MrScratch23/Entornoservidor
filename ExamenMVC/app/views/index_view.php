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
                <a href="#" class="nav-link active">Vehículos</a>
                <a href="#" class="nav-link">-- sustituir enlace --</a>
            </nav>
            <!-- información del usuario -->
            <div class="header-user">
                <div>
                    <span>-- sustituir información --</span>
                </div>
                <a href="#" class="btn-logout">🚪 Salir</a>
            </div>
        </div>
    </header>

    <!-- Contenido Principal -->
    <main class="main-content">
        <div class="content-container">
            <!-- Mensaje Flash -->
            <div class="flash-message flash-success">
                Mensaje flash de ejemplo (sólo se muestra si hay un mensaje que mostrar)
            </div>

            <section class="page-header">
                <h2>-- Vehículos: sustituir título --</h2>
                <p class="page-description">-- sustituir texto --</p>
            </section>

            <!-- Grid de Vehículos -->
            <section class="vehicles-grid">
                <!-- Mostrar cuando no hay vehículos -->
                <!-- <h1>No hay vehículos disponibles</h1> -->

                <!-- Card Vehículo 1 -->
                <article class="vehicle-card">
                    <div class="vehicle-image">
                        <img src="./img/vehiculos/vehiculo_generico.png" alt="nombre del vehículo">
                        <span class="vehicle-status status-available">Disponible</span>
                    </div>
                    <div class="vehicle-info">
                        <h3 class="vehicle-name">Nombre del vehículo</h3>
                        <p class="vehicle-plate">🚗 Matrícula: <strong>XXX-9999</strong></p>
                        <div class="vehicle-specs">
                            <div class="spec-item">
                                <span class="spec-icon">⚖️</span>
                                <div class="spec-content">
                                    <span class="spec-label">Carga Máx:</span>
                                    <span class="spec-value">1500 kg</span>
                                </div>
                            </div>
                            <div class="spec-item">
                                <span class="spec-icon">📦</span>
                                <div class="spec-content">
                                    <span class="spec-label">Volumen Máx:</span>
                                    <span class="spec-value">12 m³</span>
                                </div>
                            </div>
                            <div class="spec-item">
                                <span class="spec-icon">⛽</span>
                                <div class="spec-content">
                                    <span class="spec-label">Combustible:</span>
                                    <span class="spec-value">Diesel</span>
                                </div>
                            </div>
                            <div class="spec-item">
                                <span class="spec-icon">🛣️</span>
                                <div class="spec-content">
                                    <span class="spec-label">Kilometraje:</span>
                                    <span class="spec-value">124.500 km</span>
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
                <!-- Card Vehículo 2 -->
                <article class="vehicle-card">
                    <div class="vehicle-image">
                        <img src="./img/vehiculos/vehiculo_generico.png" alt="nombre del vehículo">
                        <span class="vehicle-status status-busy">En Ruta</span>
                    </div>
                    <div class="vehicle-info">
                        <h3 class="vehicle-name">Nombre del vehículo</h3>
                        <p class="vehicle-plate">🚗 Matrícula: <strong>XXX-9999</strong></p>
                        <div class="vehicle-specs">
                            <div class="spec-item">
                                <span class="spec-icon">⚖️</span>
                                <div class="spec-content">
                                    <span class="spec-label">Carga Máx:</span>
                                    <span class="spec-value">1500 kg</span>
                                </div>
                            </div>
                            <div class="spec-item">
                                <span class="spec-icon">📦</span>
                                <div class="spec-content">
                                    <span class="spec-label">Volumen Máx:</span>
                                    <span class="spec-value">12 m³</span>
                                </div>
                            </div>
                            <div class="spec-item">
                                <span class="spec-icon">⛽</span>
                                <div class="spec-content">
                                    <span class="spec-label">Combustible:</span>
                                    <span class="spec-value">Diesel</span>
                                </div>
                            </div>
                            <div class="spec-item">
                                <span class="spec-icon">🛣️</span>
                                <div class="spec-content">
                                    <span class="spec-label">Kilometraje:</span>
                                    <span class="spec-value">64.800 km</span>
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
                <!-- Card Vehículo 3 -->
                <article class="vehicle-card">
                    <div class="vehicle-image">
                        <img src="./img/vehiculos/vehiculo_generico.png" alt="nombre del vehículo">
                        <span class="vehicle-status status-maintenance">Mantenimiento</span>
                    </div>
                    <div class="vehicle-info">
                        <h3 class="vehicle-name">Nombre del vehículo</h3>
                        <p class="vehicle-plate">🚗 Matrícula: <strong>XXX-9999</strong></p>
                        <div class="vehicle-specs">
                            <div class="spec-item">
                                <span class="spec-icon">⚖️</span>
                                <div class="spec-content">
                                    <span class="spec-label">Carga Máx:</span>
                                    <span class="spec-value">1500 kg</span>
                                </div>
                            </div>
                            <div class="spec-item">
                                <span class="spec-icon">📦</span>
                                <div class="spec-content">
                                    <span class="spec-label">Volumen Máx:</span>
                                    <span class="spec-value">12 m³</span>
                                </div>
                            </div>
                            <div class="spec-item">
                                <span class="spec-icon">⛽</span>
                                <div class="spec-content">
                                    <span class="spec-label">Combustible:</span>
                                    <span class="spec-value">Gasolina</span>
                                </div>
                            </div>
                            <div class="spec-item">
                                <span class="spec-icon">🛣️</span>
                                <div class="spec-content">
                                    <span class="spec-label">Kilometraje:</span>
                                    <span class="spec-value">220.400 km</span>
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