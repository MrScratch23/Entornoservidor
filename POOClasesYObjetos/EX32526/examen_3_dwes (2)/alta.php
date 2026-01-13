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

    <!-- CABECERA (Menú superior estático) -->
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
            <h1 class="title">Alta de Nueva Incidencia</h1>
            <section class="card">
                <!-- FORMULARIO DE ALTA-->
                <form action="index.php" method="POST">
                    <h2 class="table-title form-section-title">Detalles del incidencia</h2>
                    <!-- Campo asunto -->
                    <div class="form-group">
                        <label for="asunto">Asunto (incidencia)</label>
                        <input type="text" id="asunto" name="asunto" placeholder="Ej: Error PC01" value="">
                        <!-- Placeholder para mensaje de error -->
                        <span class="validation-error" id="error-asunto">Ejemplo de mensaje</span>
                    </div>
                    <!-- Campo Tipo de incidencia -->
                    <div class="form-group">
                        <label for="tipo_incidencia">Tipo de Incidencia</label>
                        <select id="tipo_incidencia" name="tipo_incidencia">
                            <option value="">-- Seleccione un tipo --</option>
                            <option value="Hardware">Hardware</option>
                            <option value="Software">Software</option>
                            <option value="Red">Red</option>
                            <option value="Otros">Otros</option>
                        </select>
                        <!-- Placeholder para mensaje de error -->
                        <span class="validation-error" id="error-tipo-incidencia">Ejemplo de mensaje</span>
                    </div>
                    <!-- Campo  Horas estimadas -->
                    <div class="form-row">
                        <div class="form-group form-col-50">
                            <label for="horas_estimadas">Horas estimadas</label>
                            <input type="number" id="horas_estimadas" name="horas_estimadas" placeholder="Ej: 2" value="">
                            <!-- Placeholder para mensaje de error -->
                            <span class="validation-error" id="error-horas">Ejemplo de mensaje</span>
                        </div>
                    </div>
                    <!-- Botones de Acción -->
                    <div class="form-actions">
                        <button type="submit" class="btn btn-save">
                            Guardar incidencia
                        </button>
                        <a href="#" class="btn btn-secondary btn-cancel">
                            Cancelar
                        </a>
                    </div>
                </form>
            </section>
            <!-- Mensaje para errores o éxito -->
            <div id="flash-message-container">
                <div class="flash-message error">Ejemplo de mensaje de error</div>
                <!-- <div class="flash-message success">Ejemplo de mensaje de éxito</div> -->
            </div>
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