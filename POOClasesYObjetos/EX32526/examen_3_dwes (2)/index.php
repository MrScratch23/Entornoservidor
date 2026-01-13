<!-- 
    Plantilla HTML+CSS para el Examen PHP - 2DAW
    Profesor: P.Lluyot
    Fecha: Diciembre 2025
    IES Cristóbal de Monroy
-->
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Incidencias - Examen PHP</title>
    <link rel="stylesheet" href="css/estilos.css">
</head>
<body>
    <!-- CABECERA (Menú superior) -->
    <header class="header">
        <div class="container header-content">
            <div class="logo">
                <span class="logo-icon">⚙️</span> Gestión de Incidencias
            </div>

            <nav class="nav-menu">
                <a href="index.php">📋 Dashboard</a>
                <a href="logout.php" class="salir">🚪 Salir</a>
            </nav>
        </div>
    </header>

    <!-- CONTENIDO PRINCIPAL-->
    <main class="main-content">
        <div class="container">
            <h1 class="title">Panel de Incidencias</h1>
            <!-- TARJETAS DE ESTADÍSTICAS-->
            <section class="stats-grid">
                <div class="card stat-card total">
                    <span class="stat-icon">📝</span>
                    <div>
                        <p class="stat-label">Total Tickets</p>
                        <p class="stat-value">3</p>
                    </div>
                </div>
                <div class="card stat-card average">
                    <span class="stat-icon">⏱️</span>
                    <div>
                        <p class="stat-label">Media de Horas</p>
                        <p class="stat-value">1.33 h</p>
                    </div>
                </div>
            </section>
            <!-- MENSAJES FLASH -->
            <div id="flash-message-container">
                <div class="flash-message success">Mensaje de éxito</div>
                <!-- <div class="flash-message error">Mensaje de error</div> -->
            </div>
            <!-- TABLA DE INCIDENCIAS (CRUD) -->
            <section class="card">
                <div class="table-controls">
                    <h2 class="table-title">Listado de Incidencias</h2>
                    <!-- Enlace para ir al formulario de alta -->
                    <a href="alta.php" class="btn btn-add">
                        ➕ Nueva Incidencia
                    </a>
                </div>

                <div class="table-wrapper">
                    <!-- tabla que contiene las incidencias -->
                    <table class="crud-table">
                        <thead>
                            <tr>
                                <th>Estado</th>
                                <th>Tipo</th>
                                <th>Asunto</th>
                                <th>Horas</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- iteramos por cada incidencia -->
                            <tr>
                                <td>
                                    <!-- estado pendiente -->
                                    <span class="status-pendiente">
                                        Pendiente </span>
                                </td>
                                <td>Hardware</td>
                                <td style="font-weight: 600;">
                                    Equipo PC02 no arranca</td>
                                <td style="font-weight: 700; color: var(--color-primary);">
                                    2 h
                                </td>
                                <td>
                                    <!-- acciones (CRUD) -->
                                    <div class="table-actions">
                                        <!--enlace que actualiza el estado del viaje-->
                                        <a href="#" class="btn-toggle-status" title="Cambiar Estado">🔄</a>
                                        <!--enlace que elimina el viaje-->
                                        <a href="#" class="btn-delete" title="Eliminar">🗑️</a>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <!-- estado en curso -->
                                    <span class="status-encurso">
                                        En curso </span>
                                </td>
                                <td>Software</td>
                                <td style="font-weight: 600;">
                                    Error al iniciar sesión en el Aula Virtual</td>
                                <td style="font-weight: 700; color: var(--color-primary);">
                                    1 h
                                </td>
                                <td>
                                    <!-- acciones (CRUD) -->
                                    <div class="table-actions">
                                        <!--enlace que actualiza el estado del viaje-->
                                        <a href="#" class="btn-toggle-status" title="Cambiar Estado">🔄</a>
                                        <!--enlace que elimina el viaje-->
                                        <a href="#" class="btn-delete" title="Eliminar">🗑️</a>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <!-- estado resuelta -->
                                    <span class="status-resuelta">
                                        Resuelta </span>
                                </td>
                                <td>Red</td>
                                <td style="font-weight: 600;">
                                    Sustituir Router de 2º DAW</td>
                                <td style="font-weight: 700; color: var(--color-primary);">
                                    1 h
                                </td>
                                <td>
                                    <!-- acciones (CRUD) -->
                                    <div class="table-actions">
                                        <!--enlace que actualiza el estado del viaje-->
                                        <a href="#" class="btn-toggle-status" title="Cambiar Estado">🔄</a>
                                        <!--enlace que elimina el viaje-->
                                        <a href="#" class="btn-delete" title="Eliminar">🗑️</a>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </section>
        </div>
    </main>
    <!-- PIE DE PÁGINA -->
    <footer class="footer">
        <div class="container">
            <p>
                © 2025 IES Cristóbal de Monroy. Examen PHP.
            </p>
        </div>
    </footer>
</body>
</html>