<?php
require_once __DIR__ . '/layout/header.php';
?>

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

        <!-- FORMULARIO CORREGIDO -->
        <form action="login" method="POST">
            <div class="form-group">
                <label for="usuario">Usuario</label>
                <input type="text" id="usuario" name="usuario" value="<?php echo $_POST['usuario'] ?? ''; ?>">
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

        <!-- ERROR GENERAL -->
        <?php if (isset($errores['general'])): ?>
            <div style="background: #ffebee; color: #c62828; padding: 10px; margin: 15px 0; border-radius: 4px;">
                <?php echo $errores['general']; ?>
            </div>
        <?php endif; ?>

        <p class="link-text">
            ¿Olvidaste tu contraseña? <a href="#">Recuperar</a>
        </p>
    </div>
</body>

</html>
<?php
require_once __DIR__ . '/layout/footer.php';
?>