<?php
// registro.php
session_start();
require_once 'includes/config.php';
require_once APP_ROOT . '/models/LoginModel.php';

$loginModel = new LoginModel();
$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';
    $email = $_POST['email'] ?? '';
    $nombre = $_POST['nombre'] ?? '';
    
    // Validaciones básicas
    if (empty($username) || empty($password) || empty($email)) {
        $error = "Todos los campos son obligatorios";
    } elseif ($password !== $confirm_password) {
        $error = "Las contraseñas no coinciden";
    } elseif (strlen($password) < 6) {
        $error = "La contraseña debe tener al menos 6 caracteres";
    } else {
        $resultado = $loginModel->registrarUsuario($username, $password, $email, $nombre);
        
        if (isset($resultado['error'])) {
            $error = $resultado['error'];
        } else {
            $_SESSION['mensajeExito'] = "¡Registro exitoso! Ahora puedes iniciar sesión.";
            header("Location: login.php");
            exit();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro - Honkai Star Rail</title>
    <link rel="stylesheet" href="paginaprincipal.css">
    <link rel="stylesheet" href="registro.css">
    <style>
    </style>
</head>
<body class="personajes-page">
    <div class="register-container">
        <h1>🌟 Registrarse</h1>
        
        <?php if ($error): ?>
            <div class="error-message"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>
        
        <form method="POST" action="">
            <div class="form-group">
                <label>Nombre Completo</label>
                <input type="text" name="nombre" required>
            </div>
            
            <div class="form-group">
                <label>Usuario *</label>
                <input type="text" name="username" required>
            </div>
            
            <div class="form-group">
                <label>Email *</label>
                <input type="email" name="email" required>
            </div>
            
            <div class="form-group">
                <label>Contraseña *</label>
                <input type="password" name="password" required>
            </div>
            
            <div class="form-group">
                <label>Confirmar Contraseña *</label>
                <input type="password" name="confirm_password" required>
            </div>
            
            <button type="submit" class="btn-register">Registrarse</button>
        </form>
        
        <div class="login-link">
            ¿Ya tienes cuenta? <a href="login.php">Inicia sesión aquí</a>
        </div>
    </div>
</body>
</html>