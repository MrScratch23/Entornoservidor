<?php
session_start();

$errores = [];

// Función para limpiar todo (en el mismo archivo)
function limpiarTodo() {
    setcookie('tema', '', time() - 3600, '/');
    setcookie('idioma', '', time() - 3600, '/');
    setcookie('notificaciones', '', time() - 3600, '/');
    setcookie('nombre', '', time() - 3600, '/');
    
    session_unset();
    session_destroy();
    
    // Redirigir para evitar reenvío del formulario
    header('Location: preferencias.php');
    exit;
}

// Si se solicita limpiar
if (isset($_GET['accion']) && $_GET['accion'] === 'limpiar') {
    limpiarTodo();
}

// Procesar formulario POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $tema = htmlspecialchars(trim($_POST['tema'])) ?? '';
    $idioma = htmlspecialchars(trim($_POST['idioma'])) ?? '';
    $notificaciones = $_POST['notificaciones'] ?? 'no'; // Valor por defecto
    $nombre = $_POST['nombre'] ?? '';

    // Validaciones
    if (!empty($tema)) {
        setcookie('tema', $tema, time() + 3600, '/');
    } else {
        $errores['tema'] = "El tema no puede estar vacío.";
    }
    
    if (!empty($idioma)) {
        setcookie('idioma', $idioma, time() + 3600, '/');
    } else {
        $errores['idioma'] = "El idioma no puede estar vacío.";
    }

    // Notificaciones es opcional, siempre se guarda
    setcookie('notificaciones', $notificaciones, time() + 3600, '/');

    if (!empty($nombre)) {
        setcookie('nombre', $nombre, time() + 3600, '/');
    }

    // Si no hay errores, guardar en sesión
    if (empty($errores)) {
        $_SESSION['preferencias'] = [
            'tema' => $tema,
            'idioma' => $idioma,
            'notificaciones' => $notificaciones,
            'nombre' => $nombre,
            'ultima_actualizacion' => date('Y-m-d H:i:s')
        ];
        
        header('Location: preferencias.php');
        exit;
    }
}

// Cargar valores para mostrar
$tema = $_COOKIE['tema'] ?? ($_SESSION['preferencias']['tema'] ?? 'claro');
$idioma = $_COOKIE['idioma'] ?? ($_SESSION['preferencias']['idioma'] ?? 'es');
$notificaciones = $_COOKIE['notificaciones'] ?? ($_SESSION['preferencias']['notificaciones'] ?? 'no');
$nombre = $_COOKIE['nombre'] ?? ($_SESSION['preferencias']['nombre'] ?? '');
$fecha = $_SESSION['preferencias']['ultima_actualizacion'] ?? 'Nunca';
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Preferencias de Usuario</title>
    <style>
        .tema-claro { 
            background: white; 
            color: black; 
        }
        .tema-oscuro { 
            background: #333; 
            color: white; 
        }
        .tema-azul { 
            background: #e3f2fd; 
            color: #1565c0; 
        }
        .preferencias { 
            max-width: 600px; 
            margin: 20px auto; 
            padding: 20px; 
            border-radius: 10px; 
        }
        .tema-claro .preferencias { 
            border: 2px solid #ddd; 
            background: #f9f9f9;
        }
        .tema-oscuro .preferencias { 
            border: 2px solid #555; 
            background: #444;
        }
        .tema-azul .preferencias { 
            border: 2px solid #2196f3; 
            background: #bbdefb;
        }
        .info-actual {
            background: rgba(255,255,255,0.1);
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
        }
        .error {
            color: #d32f2f;
            font-size: 0.85em;
            margin-top: 5px;
            padding: 5px 10px;
            background: #ffebee;
            border-radius: 4px;
            display: inline-block;
        }
        .campo-con-error input,
        .campo-con-error select {
            border: 2px solid #d32f2f !important;
        }
        form {
            margin-top: 20px;
        }
        label {
            display: block;
            margin: 10px 0 5px 0;
            font-weight: bold;
        }
        input[type="text"], select {
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 4px;
            width: 200px;
            transition: border 0.3s ease;
        }
        button {
            background: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            margin-top: 15px;
        }
        button:hover {
            background: #45a049;
        }
        .btn-limpiar {
            background: #ff4444;
        }
        .btn-limpiar:hover {
            background: #cc0000;
        }
        .radio-group {
            margin: 10px 0;
        }
        .radio-group label {
            display: inline-block;
            margin-right: 15px;
            font-weight: normal;
        }
        .acciones {
            margin-top: 20px;
        }
        .limpiar {
            color: #ff4444;
            text-decoration: none;
        }
        .limpiar:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body class="tema-<?php echo $tema; ?>">
    <div class="preferencias">
        <h1>🎨 Preferencias de Usuario</h1>
        
        <div class="info-actual">
            <h3>Preferencias Actuales:</h3>
            <p><strong>Tema:</strong> <?php echo $tema; ?></p>
            <p><strong>Idioma:</strong> <?php echo $idioma; ?></p>
            <p><strong>Notificaciones:</strong> <?php echo $notificaciones; ?></p>
            <p><strong>Nombre:</strong> <?php echo !empty($nombre) ? $nombre : 'No especificado'; ?></p>
            <p><strong>Última actualización:</strong> <?php echo $fecha; ?></p>
        </div>

        <form method="POST" action="preferencias.php">
            <h3>Configurar Preferencias:</h3>
            
            <!-- Campo Tema -->
            <div class="radio-group <?php echo isset($errores['tema']) ? 'campo-con-error' : ''; ?>">
                <label>Tema:</label><br>
                <label>
                    <input type="radio" name="tema" value="claro" <?php echo $tema == 'claro' ? 'checked' : ''; ?>> 
                    🌞 Claro
                </label>
                <label>
                    <input type="radio" name="tema" value="oscuro" <?php echo $tema == 'oscuro' ? 'checked' : ''; ?>> 
                    🌙 Oscuro
                </label>
                <label>
                    <input type="radio" name="tema" value="azul" <?php echo $tema == 'azul' ? 'checked' : ''; ?>> 
                    🔵 Azul
                </label>
                <?php if (isset($errores['tema'])): ?>
                    <br><span class="error"><?php echo $errores['tema']; ?></span>
                <?php endif; ?>
            </div>
            
            <!-- Campo Idioma -->
            <div class="<?php echo isset($errores['idioma']) ? 'campo-con-error' : ''; ?>">
                <label for="idioma">Idioma:</label>
                <select name="idioma" id="idioma">
                    <option value="es" <?php echo $idioma == 'es' ? 'selected' : ''; ?>>Español</option>
                    <option value="en" <?php echo $idioma == 'en' ? 'selected' : ''; ?>>English</option>
                    <option value="fr" <?php echo $idioma == 'fr' ? 'selected' : ''; ?>>Français</option>
                    <option value="de" <?php echo $idioma == 'de' ? 'selected' : ''; ?>>Deutsch</option>
                </select>
                <?php if (isset($errores['idioma'])): ?>
                    <br><span class="error"><?php echo $errores['idioma']; ?></span>
                <?php endif; ?>
            </div>
            
            <br>
            
            <!-- Campo Notificaciones -->
            <label>
                <input type="checkbox" name="notificaciones" value="si" <?php echo $notificaciones == 'si' ? 'checked' : ''; ?>> 
                📢 Recibir notificaciones por email
            </label>
            
            <br><br>
            
            <!-- Campo Nombre -->
            <div>
                <label for="nombre">Nombre (opcional):</label>
                <input type="text" name="nombre" id="nombre" placeholder="Tu nombre" value="<?php echo htmlspecialchars($nombre); ?>">
            </div>
            
            <br>
            
            <button type="submit">💾 Guardar Preferencias</button>
        </form>
        
        <hr>
        <div class="acciones">
            <h4>Acciones:</h4>
            <a href="preferencias.php?accion=limpiar" class="limpiar" 
               onclick="return confirm('¿Estás seguro de que quieres limpiar todas las preferencias?')">
                🧹 Limpiar todas las preferencias
            </a>
        </div>
    </div>
</body>
</html>