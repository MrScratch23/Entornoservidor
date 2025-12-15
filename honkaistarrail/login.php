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
    <style>
        .login-container {
            max-width: 400px;
            margin: 50px auto;
            padding: 30px;
            background: rgba(255, 255, 255, 0.05);
            border-radius: 15px;
            border: 1px solid #667eea;
        }
        
        .login-container h1 {
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
        
        .btn-login {
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
        
        .btn-login:hover {
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
        
        .register-link {
            text-align: center;
            margin-top: 20px;
            color: #aaa;
        }
        
        .register-link a {
            color: #667eea;
            text-decoration: none;
        }
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