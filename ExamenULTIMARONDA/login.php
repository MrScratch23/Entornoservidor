<!-- 
    Plantilla HTML+CSS para el Examen PHP - 2DAW
    Profesor: P.Lluyot
    Fecha: Diciembre 2025
    IES Cristóbal de Monroy

-->

<?php
session_start();

require_once "Database.php";
require_once "LoginModel.php";

if (isset($_SESSION['usuario'])) {
    header("Location: index.php");
    exit();
}



$login = new LoginModel();

$mensaje = '';


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usuario = htmlspecialchars(trim($_POST['usuario'] ?? ''));
    $password = $_POST['password'] ?? '';
    
  
    // validaciones

    if ($usuario === '') {
        $errores['usuario'] = "Rellena el campo usuario.";
    }

    if ($password === '') {
        $errores['password'] = "El campo password debe estar relleno.";
    }

    if (empty($errores)) {
        $usuarioData = $login->autentificarUsuario($usuario, $password); 
        if ($usuarioData) {
            $_SESSION['usuario'] = $usuarioData;
            header("Location: index.php", true, 302);
            exit();
        } else {
            // error en el usuario, redirigir al mismo login
            $_SESSION['mensajeflash'] = "Error en el usuario o la contraseña no coincide con la base de datos.";
            header("Location: login.php");
            exit();
        }
    } 
}

// mostrar mensajeflash si existe
if (isset($_SESSION['mensajeflash'])) {
    $mensaje = $_SESSION['mensajeflash'];
    unset($_SESSION['mensajeflash']);
}
?>
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
                <span class="logo-icon">⚙️</span>Incidencias
            </div>
            <p class="subtitle">
                Acceso al panel de gestión.
            </p>
        </header>

        <!-- Formulario de acceso -->
        <form action="login.php" method="POST">
            <div class="form-group">
                <label for="usuario">Usuario</label>
                <input type="text" id="usuario" name="usuario" value="">
                <?php if (isset($errores['usuario'])): ?>
                <span class="validation-error" id="error-destino"><?php echo $errores['usuario'] ?></span>
                <?php endif; ?>
            </div>

            <div class="form-group">
                <label for="password">Contraseña</label>
                <input type="password" id="password" name="password" value="">
                <?php if (isset($errores['password'])): ?>
                    <span class="validation-error" id="error-password"><?php echo $errores['password']; ?></span>
                <?php endif; ?>
            </div>

            <!-- Botón de acceso -->
            <button type="submit" name="acceder" class="btn-login">
                Acceder
            </button>
        </form>
        <!-- Mensaje flash para errores o éxito -->
         <?php if (!empty($mensaje)) : ?>
        <div id="flash-message-container">
            <div class="flash-message error"><?php echo $mensaje; ?></div>
        </div>
        <?php endif; ?>
        <!-- Enlace para recuperar contraseña (no se implementa en el examen) -->
        <p class="link-text">
            ¿Olvidaste tu contraseña? <a href="#">Recuperar</a>
        </p>
    </div>
</body>

</html>