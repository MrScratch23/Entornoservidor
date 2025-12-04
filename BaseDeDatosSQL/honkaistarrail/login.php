<?php
session_start();
require_once 'includes/config.php';
require_once APP_ROOT . "/models/LoginModel.php";

$errores = [];

if (isset($_SESSION['usuario'])) {
    header("Location: index.php", true, 302);
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usuario = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    if ($usuario === '') {
        $errores['usuario'] = "El campo usuario debe estar rellenado.";
    }
    if ($password === '') {
        $errores['password'] = "El campo password debe estar rellenado.";
    }

    if (empty($errores)) {
        $loginModel = new LoginModel(); 
        $usuarioData = $loginModel->autentificarUsuario($usuario, $password);
        
        if ($usuarioData) { 
            
            $_SESSION['usuario'] = $usuarioData;
            $_SESSION['usuario_id'] = $usuarioData['id'];
            $_SESSION['usuario_nombre'] = $usuarioData['nombre'];
            $_SESSION['usuario_rol'] = $usuarioData['rol'];
            
            
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
            font-family: 'Segoe UI', 'Arial', sans-serif;
        }

        body {
            background: 
                radial-gradient(ellipse at top, rgba(15, 23, 42, 0.9) 0%, rgba(9, 11, 26, 1) 60%),
                url('data:image/svg+xml,<svg width="100" height="100" xmlns="http://www.w3.org/2000/svg"><defs><pattern id="stars" patternUnits="userSpaceOnUse" width="100" height="100"><circle cx="10" cy="10" r="0.5" fill="rgba(102, 126, 234, 0.3)"/><circle cx="40" cy="60" r="0.8" fill="rgba(147, 51, 234, 0.4)"/><circle cx="70" cy="30" r="0.3" fill="rgba(102, 126, 234, 0.5)"/><circle cx="90" cy="80" r="0.6" fill="rgba(147, 51, 234, 0.3)"/></pattern></defs><rect width="100" height="100" fill="url(%23stars)"/></svg>');
            color: #e2e8f0;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
            position: relative;
            overflow: hidden;
        }

        body::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: 
                radial-gradient(circle at 20% 80%, rgba(102, 126, 234, 0.15) 0%, transparent 50%),
                radial-gradient(circle at 80% 20%, rgba(147, 51, 234, 0.1) 0%, transparent 50%);
            z-index: -1;
        }

        .login-container {
            background: rgba(15, 23, 42, 0.7);
            border-radius: 20px;
            width: 100%;
            max-width: 480px;
            overflow: hidden;
            position: relative;
            border: 1px solid rgba(102, 126, 234, 0.3);
            box-shadow: 
                0 0 60px rgba(102, 126, 234, 0.2),
                0 0 100px rgba(147, 51, 234, 0.1),
                inset 0 0 20px rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(10px);
            animation: containerGlow 6s ease-in-out infinite alternate;
        }

        @keyframes containerGlow {
            0% {
                box-shadow: 
                    0 0 60px rgba(102, 126, 234, 0.2),
                    0 0 100px rgba(147, 51, 234, 0.1),
                    inset 0 0 20px rgba(255, 255, 255, 0.05);
            }
            100% {
                box-shadow: 
                    0 0 80px rgba(102, 126, 234, 0.3),
                    0 0 120px rgba(147, 51, 234, 0.15),
                    inset 0 0 30px rgba(255, 255, 255, 0.08);
            }
        }

        .login-header {
            background: linear-gradient(
                135deg, 
                rgba(102, 126, 234, 0.3) 0%, 
                rgba(147, 51, 234, 0.2) 100%
            );
            color: white;
            padding: 50px 40px;
            text-align: center;
            position: relative;
            overflow: hidden;
            border-bottom: 1px solid rgba(102, 126, 234, 0.3);
        }

        .login-header::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            right: -50%;
            bottom: -50%;
            background: 
                radial-gradient(circle at center, rgba(102, 126, 234, 0.1) 0%, transparent 70%),
                repeating-linear-gradient(
                    45deg,
                    transparent,
                    transparent 10px,
                    rgba(102, 126, 234, 0.05) 10px,
                    rgba(102, 126, 234, 0.05) 20px
                );
            animation: starfield 20s linear infinite;
            z-index: 0;
        }

        @keyframes starfield {
            from { transform: translateY(0) translateX(0); }
            to { transform: translateY(-20px) translateX(20px); }
        }

        .login-header h1 {
            font-size: 32px;
            margin-bottom: 15px;
            font-weight: 700;
            letter-spacing: 1px;
            position: relative;
            z-index: 1;
            text-shadow: 0 0 20px rgba(102, 126, 234, 0.7);
            background: linear-gradient(90deg, #667eea, #9333ea);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .login-header p {
            opacity: 0.9;
            font-size: 16px;
            letter-spacing: 0.5px;
            position: relative;
            z-index: 1;
            color: #c7d2fe;
        }

        .login-body {
            padding: 50px 40px;
            position: relative;
        }

        .form-group {
            margin-bottom: 30px;
            position: relative;
        }

        .form-group label {
            display: block;
            margin-bottom: 12px;
            color: #c7d2fe;
            font-weight: 500;
            font-size: 15px;
            letter-spacing: 0.5px;
        }

        .form-group input {
            width: 100%;
            padding: 18px 20px;
            background: rgba(30, 41, 59, 0.6);
            border: 1px solid rgba(102, 126, 234, 0.4);
            border-radius: 12px;
            font-size: 16px;
            color: #e2e8f0;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: inset 0 2px 10px rgba(0, 0, 0, 0.2);
        }

        .form-group input::placeholder {
            color: #94a3b8;
        }

        .form-group input:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 
                0 0 0 4px rgba(102, 126, 234, 0.15),
                inset 0 2px 10px rgba(0, 0, 0, 0.3);
            background: rgba(30, 41, 59, 0.8);
            transform: translateY(-2px);
        }

        .error-message {
            color: #f87171;
            font-size: 14px;
            margin-top: 8px;
            display: block;
            padding-left: 5px;
            text-shadow: 0 0 10px rgba(248, 113, 113, 0.3);
        }

        .error-general {
            background: rgba(220, 38, 38, 0.15);
            border: 1px solid rgba(248, 113, 113, 0.4);
            border-radius: 12px;
            padding: 18px 20px;
            margin-bottom: 30px;
            color: #fca5a5;
            text-align: center;
            font-size: 15px;
            animation: errorPulse 2s ease-in-out infinite;
            backdrop-filter: blur(5px);
            box-shadow: 0 0 20px rgba(220, 38, 38, 0.2);
        }

        @keyframes errorPulse {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.8; }
        }

        .login-button {
            width: 100%;
            padding: 20px;
            background: linear-gradient(
                135deg,
                rgba(102, 126, 234, 0.9) 0%,
                rgba(147, 51, 234, 0.8) 100%
            );
            color: white;
            border: none;
            border-radius: 12px;
            font-size: 18px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            letter-spacing: 0.5px;
            position: relative;
            overflow: hidden;
            box-shadow: 
                0 10px 30px rgba(102, 126, 234, 0.3),
                0 0 40px rgba(147, 51, 234, 0.2);
        }

        .login-button::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(
                90deg,
                transparent,
                rgba(255, 255, 255, 0.2),
                transparent
            );
            transition: 0.5s;
        }

        .login-button:hover {
            transform: translateY(-4px) scale(1.02);
            box-shadow: 
                0 20px 40px rgba(102, 126, 234, 0.4),
                0 0 60px rgba(147, 51, 234, 0.3);
        }

        .login-button:hover::before {
            left: 100%;
        }

        .login-button:active {
            transform: translateY(-1px) scale(1.01);
        }

        .register-link {
            text-align: center;
            margin-top: 40px;
            padding-top: 35px;
            border-top: 1px solid rgba(102, 126, 234, 0.2);
            color: #94a3b8;
            font-size: 15px;
        }

        .register-link a {
            color: #93c5fd;
            text-decoration: none;
            font-weight: 600;
            margin-left: 5px;
            transition: all 0.3s ease;
            position: relative;
            padding-bottom: 2px;
        }

        .register-link a::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 0;
            height: 1px;
            background: linear-gradient(90deg, #667eea, #9333ea);
            transition: width 0.3s ease;
        }

        .register-link a:hover {
            color: #60a5fa;
            text-shadow: 0 0 10px rgba(96, 165, 250, 0.5);
        }

        .register-link a:hover::after {
            width: 100%;
        }

        /* Elementos decorativos futuristas */
        .login-container::before,
        .login-container::after {
            content: '';
            position: absolute;
            width: 150px;
            height: 150px;
            border-radius: 50%;
            filter: blur(60px);
            opacity: 0.3;
            z-index: -1;
        }

        .login-container::before {
            background: radial-gradient(circle, #667eea 0%, transparent 70%);
            top: -50px;
            left: -50px;
            animation: float 8s ease-in-out infinite;
        }

        .login-container::after {
            background: radial-gradient(circle, #9333ea 0%, transparent 70%);
            bottom: -50px;
            right: -50px;
            animation: float 8s ease-in-out infinite reverse;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0) rotate(0deg); }
            50% { transform: translateY(-20px) rotate(180deg); }
        }

        /* Responsive */
        @media (max-width: 480px) {
            .login-body {
                padding: 40px 25px;
            }
            
            .login-header {
                padding: 40px 25px;
            }
            
            .login-header h1 {
                font-size: 28px;
            }
            
            .login-button {
                padding: 18px;
                font-size: 17px;
            }
            
            body {
                padding: 15px;
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
                           placeholder="usuario@ejemplo.com"
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

                <button type="submit" class="login-button">
                    Iniciar Sesión
                </button>
            </form>
        </div>
    </div>
</body>
</html>