<?php
session_start();
require_once 'includes/config.php';
require_once APP_ROOT . "/models/LoginModel.php";
require_once APP_ROOT . "/includes/Database.php"; // Necesitamos Database para obtener datos del usuario

$errores = [];

// Si ya está logueado, redirigir a index
if (isset($_SESSION['usuario'])) {
    header("Location: index.php", true, 302);
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usuario = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    // Validaciones básicas
    if ($usuario === '') {
        $errores['usuario'] = "El campo usuario debe estar rellenado.";
    }
    if ($password === '') {
        $errores['password'] = "El campo password debe estar rellenado.";
    }

    if (empty($errores)) {
        $loginModel = new LoginModel(); 
        $autenticado = $loginModel->autentificarUsuario($usuario, $password);
        
        if ($autenticado) { 
            // Obtener datos completos del usuario para guardar en sesión
            $db = new Database();
            $sql = "SELECT id, usuario, rol FROM usuarios WHERE usuario = ?";
            $datosUsuario = $db->executeQuery($sql, [$usuario]);
            
            if (!empty($datosUsuario)) {
                // Guardar array con datos del usuario en sesión
                $_SESSION['usuario'] = [
                    'id' => $datosUsuario[0]['id'],
                    'nombre' => $datosUsuario[0]['usuario'],
                    'rol' => $datosUsuario[0]['rol']
                ];
            } else {
                $_SESSION['usuario'] = $usuario;
            }
            
            header("Location: index.php", true, 302);
            exit();
        } else {
            $errores['general'] = "Usuario o contraseña incorrectos";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Sistema PHP</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Arial', sans-serif;
        }

        body {
            background-color: #f5f5f5;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }

        .login-container {
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 450px;
            overflow: hidden;
        }

        .login-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 40px 30px;
            text-align: center;
        }

        .login-header h1 {
            font-size: 28px;
            margin-bottom: 10px;
            font-weight: 600;
        }

        .login-header p {
            opacity: 0.9;
            font-size: 16px;
        }

        .login-body {
            padding: 40px;
        }

        .form-group {
            margin-bottom: 25px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            color: #333;
            font-weight: 500;
            font-size: 14px;
        }

        .form-group input {
            width: 100%;
            padding: 15px;
            border: 2px solid #e1e1e1;
            border-radius: 8px;
            font-size: 16px;
            transition: all 0.3s ease;
        }

        .form-group input:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }

        .form-group input::placeholder {
            color: #999;
        }

        .error-message {
            color: #e74c3c;
            font-size: 14px;
            margin-top: 5px;
            display: block;
        }

        .error-general {
            background-color: #fee;
            border: 1px solid #f99;
            border-radius: 8px;
            padding: 12px 15px;
            margin-bottom: 20px;
            color: #c00;
            text-align: center;
            font-size: 15px;
            animation: fadeIn 0.3s ease;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-5px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .login-button {
            width: 100%;
            padding: 16px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 17px;
            font-weight: 600;
            cursor: pointer;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
            margin-bottom: 15px;
        }

        .login-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.3);
        }

        .login-button:active {
            transform: translateY(0);
        }

        .register-button {
            width: 100%;
            padding: 16px;
            background-color: #f8f9fa;
            color: #667eea;
            border: 2px solid #667eea;
            border-radius: 8px;
            font-size: 17px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .register-button:hover {
            background-color: #667eea;
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.2);
        }

        .register-button:active {
            transform: translateY(0);
        }

        .button-container {
            display: flex;
            flex-direction: column;
        }

        .separator {
            text-align: center;
            margin: 10px 0;
            color: #666;
            font-size: 14px;
            position: relative;
        }

        .separator::before,
        .separator::after {
            content: '';
            position: absolute;
            top: 50%;
            width: 45%;
            height: 1px;
            background-color: #ddd;
        }

        .separator::before {
            left: 0;
        }

        .separator::after {
            right: 0;
        }

        .register-link {
            text-align: center;
            margin-top: 20px;
            color: #666;
            font-size: 15px;
        }

        .register-link a {
            color: #667eea;
            text-decoration: none;
            font-weight: 600;
            transition: color 0.2s ease;
        }

        .register-link a:hover {
            color: #764ba2;
            text-decoration: underline;
        }

        @media (max-width: 480px) {
            .login-body {
                padding: 30px 20px;
            }
            
            .login-header {
                padding: 30px 20px;
            }
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-header">
            <h1>Bienvenido</h1>
            <p>Ingresa a tu cuenta para continuar</p>
        </div>

        <div class="login-body">
            <form method="POST" action="">
                <!-- Mensaje de error general -->
                <?php if (isset($errores['general'])): ?>
                <div class="error-general">
                    <i style="margin-right: 8px;">⚠</i>
                    <?php echo htmlspecialchars($errores['general']); ?>
                </div>
                <?php endif; ?>

                <div class="form-group">
                    <label for="username">Usuario</label>
                    <input type="text" 
                           id="username" 
                           name="username" 
                           placeholder="Ingresa tu usuario"
                           value="<?php echo htmlspecialchars($_POST['username'] ?? ''); ?>">
                    <?php if (isset($errores['usuario'])): ?>
                    <span class="error-message"><?php echo htmlspecialchars($errores['usuario']); ?></span>
                    <?php endif; ?>
                </div>

                <div class="form-group">
                    <label for="password">Contraseña</label>
                    <input type="password" 
                           id="password" 
                           name="password" 
                           placeholder="Ingresa tu contraseña">
                    <?php if (isset($errores['password'])): ?>
                    <span class="error-message"><?php echo htmlspecialchars($errores['password']); ?></span>
                    <?php endif; ?>
                </div>

                <div class="button-container">
                    <button type="submit" class="login-button">
                        Iniciar Sesión
                    </button>
                    
                    <div class="separator">o</div>
                              
                
                <div class="register-link">
                    ¿No tienes una cuenta? <a href="registro.php">Regístrate aquí</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>