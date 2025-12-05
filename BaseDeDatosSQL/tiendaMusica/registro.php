<?php
session_start();
require_once 'includes/config.php';
require_once APP_ROOT . "/includes/Database.php";

$errores = [];
$mensaje_exito = '';

// Si ya está logueado, redirigir a index
if (isset($_SESSION['usuario'])) {
    header("Location: index.php", true, 302);
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Recoger datos del formulario
    $usuario = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirmar_password = $_POST['confirm_password'] ?? '';
    $email = trim($_POST['email'] ?? '');
    $nombre_completo = trim($_POST['nombre_completo'] ?? '');

    
    if ($usuario === '') {
        $errores['usuario'] = "El campo usuario es obligatorio.";
    } elseif (strlen($usuario) < 3) {
        $errores['usuario'] = "El usuario debe tener al menos 3 caracteres.";
    } elseif (!preg_match('/^[a-zA-Z0-9_]+$/', $usuario)) {
        $errores['usuario'] = "El usuario solo puede contener letras, números y guiones bajos.";
    }

    if ($email === '') {
        $errores['email'] = "El campo email es obligatorio.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errores['email'] = "El formato del email no es válido.";
    }

    if ($password === '') {
        $errores['password'] = "El campo contraseña es obligatorio.";
    } elseif (strlen($password) < 6) {
        $errores['password'] = "La contraseña debe tener al menos 6 caracteres.";
    }

    if ($confirmar_password === '') {
        $errores['confirm_password'] = "Debes confirmar tu contraseña.";
    } elseif ($password !== $confirmar_password) {
        $errores['confirm_password'] = "Las contraseñas no coinciden.";
    }

    
    if (empty($errores)) {
        try {
            $db = new Database();
            
            // Verificar usuario existente
            $sql_usuario = "SELECT id FROM usuarios WHERE usuario = ?";
            $usuario_existente = $db->executeQuery($sql_usuario, [$usuario]);
            
            if (!empty($usuario_existente)) {
                $errores['usuario'] = "Este nombre de usuario ya está registrado.";
            }
            
            // Verificar email existente
            $sql_email = "SELECT id FROM usuarios WHERE email = ?";
            $email_existente = $db->executeQuery($sql_email, [$email]);
            
            if (!empty($email_existente)) {
                $errores['email'] = "Este correo electrónico ya está registrado.";
            }
            
            // Si no hay errores, crear el usuario
            if (empty($errores)) {
                // Hash de la contraseña
                $password_hash = password_hash($password, PASSWORD_DEFAULT);
                
                // Insertar usuario en la base de datos
                $sql_insert = "INSERT INTO usuarios (usuario, password, email, nombre_completo, rol, fecha_registro) 
                               VALUES (?, ?, ?, ?, 'usuario', NOW())";
                
                $resultado = $db->executeUpdate($sql_insert, [
                    $usuario, 
                    $password_hash, 
                    $email, 
                    $nombre_completo
                ]);
                
                if ($resultado) {
                    $mensaje_exito = "¡Registro exitoso! Ya puedes iniciar sesión.";
                    
                    // Limpiar campos del formulario
                    $usuario = $email = $nombre_completo = '';
                } else {
                    $errores['general'] = "Error al registrar el usuario. Por favor, intenta nuevamente.";
                }
            }
        } catch (Exception $e) {
            $errores['general'] = "Error en el servidor: " . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro - Sistema PHP</title>
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

        .register-container {
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 500px;
            overflow: hidden;
        }

        .register-header {
            background: linear-gradient(135deg, #4CAF50 0%, #45a049 100%);
            color: white;
            padding: 40px 30px;
            text-align: center;
        }

        .register-header h1 {
            font-size: 28px;
            margin-bottom: 10px;
            font-weight: 600;
        }

        .register-header p {
            opacity: 0.9;
            font-size: 16px;
        }

        .register-body {
            padding: 40px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            color: #333;
            font-weight: 500;
            font-size: 14px;
        }

        .form-group.required label::after {
            content: " *";
            color: #e74c3c;
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
            border-color: #4CAF50;
            box-shadow: 0 0 0 3px rgba(76, 175, 80, 0.1);
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

        .success-message {
            background-color: #d4edda;
            border: 1px solid #c3e6cb;
            border-radius: 8px;
            padding: 12px 15px;
            margin-bottom: 20px;
            color: #155724;
            text-align: center;
            font-size: 15px;
            animation: fadeIn 0.3s ease;
        }

        .success-message a {
            color: #155724;
            font-weight: bold;
            text-decoration: underline;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-5px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .register-button {
            width: 100%;
            padding: 16px;
            background: linear-gradient(135deg, #4CAF50 0%, #45a049 100%);
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 17px;
            font-weight: 600;
            cursor: pointer;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
            margin-top: 10px;
        }

        .register-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(76, 175, 80, 0.3);
        }

        .register-button:active {
            transform: translateY(0);
        }

        .cancel-button {
            width: 100%;
            padding: 16px;
            background-color: #f8f9fa;
            color: #666;
            border: 2px solid #ddd;
            border-radius: 8px;
            font-size: 17px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s ease;
            margin-top: 10px;
        }

        .cancel-button:hover {
            background-color: #e9ecef;
            transform: translateY(-2px);
        }

        .cancel-button:active {
            transform: translateY(0);
        }

        .button-container {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .login-link {
            text-align: center;
            margin-top: 20px;
            color: #666;
            font-size: 15px;
        }

        .login-link a {
            color: #4CAF50;
            text-decoration: none;
            font-weight: 600;
            transition: color 0.2s ease;
        }

        .login-link a:hover {
            color: #45a049;
            text-decoration: underline;
        }

        @media (max-width: 480px) {
            .register-body {
                padding: 30px 20px;
            }
            
            .register-header {
                padding: 30px 20px;
            }
        }
    </style>
</head>
<body>
    <div class="register-container">
        <div class="register-header">
            <h1>Crear Cuenta</h1>
            <p>Regístrate para acceder al sistema</p>
        </div>

        <div class="register-body">
            <form method="POST" action="">
                <!-- Mensaje de éxito -->
                <?php if (isset($mensaje_exito) && $mensaje_exito): ?>
                <div class="success-message">
                    <i style="margin-right: 8px;">✓</i>
                    <?php echo htmlspecialchars($mensaje_exito); ?>
                    <br>
                    <a href="login.php">Ir al inicio de sesión</a>
                </div>
                <?php endif; ?>

                <!-- Mensaje de error general -->
                <?php if (isset($errores['general'])): ?>
                <div class="error-general">
                    <i style="margin-right: 8px;">⚠</i>
                    <?php echo htmlspecialchars($errores['general']); ?>
                </div>
                <?php endif; ?>

                <div class="form-group required">
                    <label for="username">Usuario</label>
                    <input type="text" 
                           id="username" 
                           name="username" 
                           placeholder="Ingresa tu nombre de usuario"
                           value="<?php echo htmlspecialchars($usuario ?? ''); ?>">
                    <?php if (isset($errores['usuario'])): ?>
                    <span class="error-message"><?php echo htmlspecialchars($errores['usuario']); ?></span>
                    <?php endif; ?>
                </div>

                <div class="form-group required">
                    <label for="email">Correo Electrónico</label>
                    <input type="email" 
                           id="email" 
                           name="email" 
                           placeholder="ejemplo@correo.com"
                           value="<?php echo htmlspecialchars($email ?? ''); ?>">
                    <?php if (isset($errores['email'])): ?>
                    <span class="error-message"><?php echo htmlspecialchars($errores['email']); ?></span>
                    <?php endif; ?>
                </div>

                <div class="form-group">
                    <label for="nombre_completo">Nombre Completo</label>
                    <input type="text" 
                           id="nombre_completo" 
                           name="nombre_completo" 
                           placeholder="Opcional"
                           value="<?php echo htmlspecialchars($nombre_completo ?? ''); ?>">
                </div>

                <div class="form-group required">
                    <label for="password">Contraseña</label>
                    <input type="password" 
                           id="password" 
                           name="password" 
                           placeholder="Mínimo 6 caracteres">
                    <?php if (isset($errores['password'])): ?>
                    <span class="error-message"><?php echo htmlspecialchars($errores['password']); ?></span>
                    <?php endif; ?>
                </div>

                <div class="form-group required">
                    <label for="confirm_password">Confirmar Contraseña</label>
                    <input type="password" 
                           id="confirm_password" 
                           name="confirm_password" 
                           placeholder="Repite tu contraseña">
                    <?php if (isset($errores['confirm_password'])): ?>
                    <span class="error-message"><?php echo htmlspecialchars($errores['confirm_password']); ?></span>
                    <?php endif; ?>
                </div>

                <div class="button-container">
                    <button type="submit" class="register-button">
                        Crear Cuenta
                    </button>
                    
                    <button type="button" class="cancel-button" onclick="window.location.href='login.php'">
                        Cancelar
                    </button>
                </div>
                
                <div class="login-link">
                    ¿Ya tienes una cuenta? <a href="login.php">Inicia sesión aquí</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>