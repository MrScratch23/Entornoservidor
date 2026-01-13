<!-- 
    Plantilla HTML+CSS para el Examen PHP - 2DAW
    Profesor: P.Lluyot
    Fecha: Diciembre 2025
    IES Cristóbal de Monroy
-->
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Incidencias - Examen PHP</title>
    <link rel="stylesheet" href="css/estilos.css">
</head>

<body>
    <!-- Capa principal de login -->
    <div class="login-card">
        <!-- Cabecera con logo y título -->
        <header>
            <div class="logo">
                <span class="logo-icon">⚙️</span> Incidencias
            </div>
            <p class="subtitle">
                Acceso al panel de gestión.
            </p>
        </header>

        <!-- Formulario de acceso -->
        <form action="index.php" method="POST">
            <div class="form-group">
                <label for="usuario">Usuario</label>
                <input type="text" id="usuario" name="usuario" value="">
                <!-- Mensaje de error para usuario -->
                <span class="validation-error" id="error-destino">Ejemplo de mensaje</span>
            </div>

            <div class="form-group">
                <label for="password">Contraseña</label>
                <input type="password" id="password" name="password" value="">
                <!-- Mensaje de error para contraseña -->
                <span class="validation-error" id="error-password">Ejemplo de mensaje</span>
            </div>

            <!-- Botón de acceso -->
            <button type="submit" name="acceder" class="btn-login">
                Acceder
            </button>
        </form>
        <!-- Mensaje flash para errores o éxito -->
        <div id="flash-message-container">
            <div class="flash-message error">Ejemplo de mensaje de error</div>
            <!-- <div class="flash-message success">Ejemplo de mensaje de éxito</div> -->
        </div>
        <!-- Enlace para recuperar contraseña (no se implementa en el examen) -->
        <p class="link-text">
            ¿Olvidaste tu contraseña? <a href="#">Recuperar</a>
        </p>
    </div>
</body>

</html>