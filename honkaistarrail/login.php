<?php
// login.php
session_start();
require_once 'includes/config.php';
require_once APP_ROOT . '/models/LoginModel.php';

$loginModel = new LoginModel();
$error = '';
$mensaje = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';
    
    $usuario = $loginModel->autentificarUsuario($username, $password);
    
    if ($usuario) {
        $_SESSION['usuario_id'] = $usuario['id'];
        $_SESSION['usuario_username'] = $usuario['username'];
        $_SESSION['usuario_nombre'] = $usuario['nombre'];
        $_SESSION['usuario_rol'] = $usuario['rol'];
        
        header("Location: index.php");
        exit();
    } else {
        $error = "Usuario o contraseña incorrectos";
    }
}

// Obtener mensaje de éxito del registro
if (isset($_SESSION['mensajeExito'])) {
    $mensaje = $_SESSION['mensajeExito'];
    unset($_SESSION['mensajeExito']);
}

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Honkai Star Rail</title>
    <link rel="stylesheet" href="paginaprincipal.css">
    <link rel="stylesheet" href="login.css">
    <style>
      
    </style>
</head>
<body class="personajes-page">
    <div class="login-container">
        <h1>🌟 Iniciar Sesión</h1>
        
        <?php if ($error): ?>
            <div class="error-message"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>

        <?php if ($mensaje): ?>
            <div class="success-message"><?php echo htmlspecialchars($mensaje); ?></div> <!-- CORREGIDO: $mensaje en lugar de $error -->
        <?php endif; ?>
        
        <form method="POST" action="">
            <div class="form-group">
                <label>Usuario o Email</label>
                <input type="text" name="username" required>
            </div>
            
            <div class="form-group">
                <label>Contraseña</label>
                <input type="password" name="password" required>
            </div>
            
            <button type="submit" class="btn-login">Iniciar Sesión</button>
        </form>
        
        <div class="register-link">
            ¿No tienes cuenta? <a href="registro.php">Regístrate aquí</a>
        </div>
    </div>
</body>
</html>