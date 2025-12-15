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
    <style>
        .register-container {
            max-width: 400px;
            margin: 50px auto;
            padding: 30px;
            background: rgba(255, 255, 255, 0.05);
            border-radius: 15px;
            border: 1px solid #667eea;
        }
        
        .register-container h1 {
            text-align: center;
            color: #667eea;
            margin-bottom: 30px;
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        .form-group label {
            display: block;
            margin-bottom: 8px;
            color: #aaa;
        }
        
        .form-group input {
            width: 100%;
            padding: 12px;
            border: 1px solid #667eea;
            border-radius: 8px;
            background: rgba(255, 255, 255, 0.1);
            color: white;
            font-size: 1rem;
        }
        
        .btn-register {
            width: 100%;
            padding: 12px;
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 1rem;
            font-weight: bold;
            cursor: pointer;
            transition: transform 0.3s;
        }
        
        .btn-register:hover {
            transform: translateY(-2px);
        }
        
        .error-message {
            background: rgba(255, 0, 0, 0.1);
            color: #ff6b6b;
            padding: 10px;
            border-radius: 8px;
            margin-bottom: 20px;
            text-align: center;
            border: 1px solid #ff6b6b;
        }
        
        .success-message {
            background: rgba(0, 255, 0, 0.1);
            color: #4CAF50;
            padding: 10px;
            border-radius: 8px;
            margin-bottom: 20px;
            text-align: center;
            border: 1px solid #4CAF50;
        }
        
        .login-link {
            text-align: center;
            margin-top: 20px;
            color: #aaa;
        }
        
        .login-link a {
            color: #667eea;
            text-decoration: none;
        }
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