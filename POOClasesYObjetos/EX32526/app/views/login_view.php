<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Incidencias - Examen PHP</title>
    <link rel="stylesheet" href="css/estilos.css">
</head>

<body>
    <div class="login-card">
        <header>
            <div class="logo">
                <span class="logo-icon">⚙️</span> Incidencias
            </div>
            <p class="subtitle">
                Acceso al panel de gestión.
            </p>
        </header>

        
        <?php if (!empty($mensaje)): ?>
            <div class="mensaje-exito">
                ✅ <?php echo htmlspecialchars($mensaje); ?>
            </div>
        <?php endif; ?>

        
        <form action="login" method="POST">
            <div class="form-group">
                <label for="usuario">Usuario</label>
                <input type="text" id="usuario" name="usuario" value="<?php echo htmlspecialchars($_POST['usuario'] ?? ''); ?>">
                <?php if (isset($errores['usuario'])): ?>
                    <br><span class="validation-error"><?php echo $errores['usuario']; ?></span>
                <?php endif; ?>
            </div>

            <div class="form-group">
                <label for="password">Contraseña</label>
                <input type="password" id="password" name="password" value="">
                <?php if (isset($errores['password'])): ?>
                    <br><span class="validation-error"><?php echo $errores['password']; ?></span>
                <?php endif; ?>
            </div>

            <button type="submit" name="acceder" class="btn-login">
                Acceder
            </button>
        </form>
       
        <div id="flash-message-container">
        <?php if (isset($errores['general'])): ?>
            <div class="flash-message error">
                ❌ <?php echo $errores['general']; ?>
            </div>
        <?php endif; ?>
        </div>

        <p class="link-text">
            ¿Olvidaste tu contraseña? <a href="#">Recuperar</a>
        </p>
    </div>
</body>

</html>
<?php
require_once __DIR__ . '/layout/footer.php';
?>