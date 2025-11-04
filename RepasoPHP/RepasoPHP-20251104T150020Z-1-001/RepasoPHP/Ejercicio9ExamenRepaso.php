<?php
// ==================== EXAMEN PHP - PRIMER TRIMESTRE DAW ====================
// ALUMNO: ___________________________ FECHA: ___________________

// ==================== EJERCICIO 1: VALIDACIÓN DE FORMULARIO ====================
$erroresEj1 = [
    'nombre' => '',
    'email' => '',
    'edad' => '',
    'password' => ''
];
$exitoEj1 = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['ejercicio1'])) {
    // 1. Sanitizar datos
    $nombre = isset($_POST['nombre']) ? htmlspecialchars(trim($_POST['nombre'])) : '';
    $email = isset($_POST['email']) ? htmlspecialchars(trim($_POST['email'])) : '';
    $edad = isset($_POST['edad']) ? $_POST['edad'] : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';

    // 2. Validaciones:
    // Nombre
    if (empty($nombre)) {
        $erroresEj1['nombre'] = "El nombre no puede estar vacío.";
    } elseif (strlen($nombre) < 2) {
        $erroresEj1['nombre'] = "El nombre debe tener mínimo 2 caracteres.";
    } else {
        $erroresEj1['nombre'] = '';
    }

    // Email
    if (empty($email)) {
        $erroresEj1['email'] = "El email no puede estar vacío.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $erroresEj1['email'] = "El formato del email no es válido.";
    } else {
        $erroresEj1['email'] = '';
    }

    // Edad
    if (empty($edad)) {
        $erroresEj1['edad'] = "La edad no puede estar vacía.";
    } elseif (!filter_var($edad, FILTER_VALIDATE_INT, array("options" => array("min_range" => 18, "max_range" => 99)))) {
        $erroresEj1['edad'] = "La edad debe ser un número entre 18 y 99.";
    } else {
        $erroresEj1['edad'] = '';
    }

    // Password
    if (empty($password)) {
        $erroresEj1['password'] = "La contraseña no puede estar vacía.";
    } elseif (strlen($password) < 6) {
        $erroresEj1['password'] = "La contraseña debe tener mínimo 6 caracteres.";
    } else {
        $erroresEj1['password'] = '';
    }

    // 3. Si no hay errores, mostrar mensaje de éxito
    $hayErrores = false;
    foreach ($erroresEj1 as $error) {
        if (!empty($error)) {
            $hayErrores = true;
            break;
        }
    }
    
    if (!$hayErrores) {
        $exitoEj1 = "✅ Usuario registrado correctamente.";
    }
}

// ==================== EJERCICIO 2: FILTRAR USUARIOS ====================
function filtrarUsuariosValidos($usuarios) {
    $validos = [];

    foreach ($usuarios as $usuario) {
        if (
            $usuario['edad'] >= 18 &&
            filter_var($usuario['email'], FILTER_VALIDATE_EMAIL)
        ) {
            $validos[] = $usuario;
        }
    }

    return $validos;
}

// Array de prueba para el ejercicio 2
$usuarios = [
    ['nombre' => 'Ana', 'email' => 'ana@email.com', 'edad' => 25],
    ['nombre' => 'Luis', 'email' => 'luis@email.com', 'edad' => 17],
    ['nombre' => 'Marta', 'email' => 'marta', 'edad' => 30],
    ['nombre' => 'Carlos', 'email' => 'carlos@email.com', 'edad' => 16],
    ['nombre' => 'Elena', 'email' => 'elena@email.com', 'edad' => 22]
];

$usuariosValidos = filtrarUsuariosValidos($usuarios);

// ==================== EJERCICIO 3: SISTEMA DE CONTACTOS ====================
$erroresEj3 = [
    'nombre_contacto' => '',
    'email_contacto' => '',
    'mensaje' => ''
];
$exitoEj3 = '';

// Función para verificar si un email ya existe en contactos.txt
function emailExisteEnContactos($email) {
    if (!file_exists('contactos.txt')) {
        return false;
    }
    
    $lineas = file('contactos.txt', FILE_IGNORE_NEW_LINES);
    foreach ($lineas as $linea) {
        $partes = explode('|', $linea);
        if (isset($partes[2]) && trim($partes[2]) === $email) {
            return true;
        }
    }
    return false;
}

// Función para guardar contacto
function guardarContacto($nombre, $email, $mensaje) {
    $fecha = date('Y-m-d H:i:s');
    $linea = "$fecha|$nombre|$email|$mensaje" . PHP_EOL;
    return file_put_contents('contactos.txt', $linea, FILE_APPEND | LOCK_EX);
}

// Función para mostrar contactos
function mostrarContactos() {
    if (!file_exists('contactos.txt')) {
        return "<p>No hay contactos guardados aún.</p>";
    }
    
    $lineas = file('contactos.txt', FILE_IGNORE_NEW_LINES);
    if (empty($lineas)) {
        return "<p>No hay contactos guardados.</p>";
    }
    
    $html = '<div class="lista-contactos">';
    foreach ($lineas as $linea) {
        $partes = explode('|', $linea);
        if (count($partes) >= 4) {
            $html .= '<div class="contacto-item">';
            $html .= '<strong>Fecha:</strong> ' . htmlspecialchars($partes[0]) . '<br>';
            $html .= '<strong>Nombre:</strong> ' . htmlspecialchars($partes[1]) . '<br>';
            $html .= '<strong>Email:</strong> ' . htmlspecialchars($partes[2]) . '<br>';
            $html .= '<strong>Mensaje:</strong> ' . htmlspecialchars($partes[3]);
            $html .= '</div><hr>';
        }
    }
    $html .= '</div>';
    return $html;
}

// Procesar formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['ejercicio3'])) {
    // 1. Sanitizar datos
    $nombre = isset($_POST['nombre_contacto']) ? htmlspecialchars(trim($_POST['nombre_contacto'])) : '';
    $email = isset($_POST['email_contacto']) ? htmlspecialchars(trim($_POST['email_contacto'])) : '';
    $mensaje = isset($_POST['mensaje']) ? htmlspecialchars(trim($_POST['mensaje'])) : '';

    // 2. Validaciones
    // Nombre
    if (empty($nombre)) {
        $erroresEj3['nombre_contacto'] = "El nombre no puede estar vacío.";
    } elseif (strlen($nombre) < 2) {
        $erroresEj3['nombre_contacto'] = "El nombre debe tener mínimo 2 caracteres.";
    } else {
        $erroresEj3['nombre_contacto'] = '';
    }

    // Email
    if (empty($email)) {
        $erroresEj3['email_contacto'] = "El email no puede estar vacío.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $erroresEj3['email_contacto'] = "El formato del email no es válido.";
    } elseif (emailExisteEnContactos($email)) {
        $erroresEj3['email_contacto'] = "Este email ya está registrado en nuestros contactos.";
    } else {
        $erroresEj3['email_contacto'] = '';
    }

    // Mensaje
    if (empty($mensaje)) {
        $erroresEj3['mensaje'] = "El mensaje no puede estar vacío.";
    } elseif (strlen($mensaje) < 10) {
        $erroresEj3['mensaje'] = "El mensaje debe tener mínimo 10 caracteres.";
    } elseif (strlen($mensaje) > 500) {
        $erroresEj3['mensaje'] = "El mensaje no puede tener más de 500 caracteres.";
    } else {
        $erroresEj3['mensaje'] = '';
    }

    // 3. Si no hay errores, guardar contacto
    $hayErrores = false;
    foreach ($erroresEj3 as $error) {
        if (!empty($error)) {
            $hayErrores = true;
            break;
        }
    }
    
    if (!$hayErrores) {
        if (guardarContacto($nombre, $email, $mensaje)) {
            $exitoEj3 = "✅ Contacto guardado correctamente.";
        } else {
            $exitoEj3 = "❌ Error al guardar el contacto.";
        }
    }
}

// ==================== EJERCICIO EXTRA: SISTEMA DE COMENTARIOS ====================
$erroresExtra = [
    'nombre_comentario' => '',
    'email_comentario' => '',
    'comentario' => ''
];
$exitoExtra = '';

// Función para guardar comentario
function guardarComentario($nombre, $email, $comentario) {
    $fecha = date('Y-m-d H:i:s');
    $linea = "$fecha|$nombre|$email|$comentario" . PHP_EOL;
    return file_put_contents('comentarios.txt', $linea, FILE_APPEND | LOCK_EX);
}

// Función para mostrar últimos 5 comentarios
function mostrarUltimosComentarios() {
    if (!file_exists('comentarios.txt')) {
        return "<p>No hay comentarios aún.</p>";
    }
    
    $lineas = file('comentarios.txt', FILE_IGNORE_NEW_LINES);
    if (empty($lineas)) {
        return "<p>No hay comentarios.</p>";
    }
    
    // Tomar últimos 5 comentarios
    $ultimosComentarios = array_slice($lineas, -5);
    $ultimosComentarios = array_reverse($ultimosComentarios); // Más recientes primero
    
    $html = '<div class="lista-comentarios">';
    foreach ($ultimosComentarios as $linea) {
        $partes = explode('|', $linea);
        if (count($partes) >= 4) {
            $html .= '<div class="comentario-item">';
            $html .= '<strong>' . htmlspecialchars($partes[1]) . '</strong> (' . htmlspecialchars($partes[0]) . ')<br>';
            $html .= '<em>' . htmlspecialchars($partes[2]) . '</em><br>';
            $html .= '<p>' . htmlspecialchars($partes[3]) . '</p>';
            $html .= '</div><hr>';
        }
    }
    $html .= '</div>';
    return $html;
}

// Procesar formulario de comentarios
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['ejercicio_extra'])) {
    // 1. Sanitizar datos
    $nombre = isset($_POST['nombre_comentario']) ? htmlspecialchars(trim($_POST['nombre_comentario'])) : '';
    $email = isset($_POST['email_comentario']) ? htmlspecialchars(trim($_POST['email_comentario'])) : '';
    $comentario = isset($_POST['comentario']) ? htmlspecialchars(trim($_POST['comentario'])) : '';

    // 2. Validaciones
    // Nombre
    if (empty($nombre)) {
        $erroresExtra['nombre_comentario'] = "El nombre no puede estar vacío.";
    } elseif (strlen($nombre) < 2) {
        $erroresExtra['nombre_comentario'] = "El nombre debe tener mínimo 2 caracteres.";
    } else {
        $erroresExtra['nombre_comentario'] = '';
    }

    // Email
    if (empty($email)) {
        $erroresExtra['email_comentario'] = "El email no puede estar vacío.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $erroresExtra['email_comentario'] = "El formato del email no es válido.";
    } else {
        $erroresExtra['email_comentario'] = '';
    }

    // Comentario
    if (empty($comentario)) {
        $erroresExtra['comentario'] = "El comentario no puede estar vacío.";
    } elseif (strlen($comentario) < 5) {
        $erroresExtra['comentario'] = "El comentario debe tener mínimo 5 caracteres.";
    } elseif (strlen($comentario) > 1000) {
        $erroresExtra['comentario'] = "El comentario no puede tener más de 1000 caracteres.";
    } else {
        $erroresExtra['comentario'] = '';
    }

    // 3. Si no hay errores, guardar comentario
    $hayErrores = false;
    foreach ($erroresExtra as $error) {
        if (!empty($error)) {
            $hayErrores = true;
            break;
        }
    }
    
    if (!$hayErrores) {
        if (guardarComentario($nombre, $email, $comentario)) {
            $exitoExtra = "✅ Comentario publicado correctamente.";
        } else {
            $exitoExtra = "❌ Error al publicar el comentario.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EXAMEN PHP - PRIMER TRIMESTRE DAW</title>
    <style>
        * { box-sizing: border-box; }
        body { font-family: Arial, sans-serif; max-width: 1200px; margin: 0 auto; padding: 20px; }
        .ejercicio { margin: 30px 0; padding: 20px; border: 2px solid #333; border-radius: 10px; background: #f9f9f9; }
        .error { color: #d63031; font-size: 0.9em; margin-top: 5px; display: block; }
        .exito { color: #00b894; background: #e8f5e8; padding: 10px; border: 1px solid #00b894; border-radius: 5px; margin: 10px 0; }
        form { margin: 15px 0; padding: 20px; background: white; border-radius: 8px; border: 1px solid #ddd; }
        label { display: block; margin: 10px 0 5px 0; font-weight: bold; }
        input, textarea, button { width: 100%; padding: 10px; margin: 5px 0; border: 1px solid #ddd; border-radius: 4px; }
        textarea { height: 100px; resize: vertical; }
        button { background: #007bff; color: white; border: none; padding: 12px 15px; cursor: pointer; font-size: 16px; }
        button:hover { background: #0056b3; }
        .usuario { padding: 15px; margin: 10px 0; border: 1px solid #ddd; border-radius: 5px; }
        .valido { background: #d4edda; border-color: #c3e6cb; }
        .invalido { background: #f8d7da; border-color: #f5c6cb; }
        .contacto-item, .comentario-item { padding: 15px; margin: 10px 0; background: white; border: 1px solid #ddd; border-radius: 5px; }
        .lista-contactos, .lista-comentarios { max-height: 400px; overflow-y: auto; }
        footer { margin-top: 40px; padding: 20px; background: #e9ecef; border-radius: 5px; text-align: center; }
        h1 { color: #2d3436; text-align: center; border-bottom: 3px solid #007bff; padding-bottom: 10px; }
        h2 { color: #2d3436; border-left: 4px solid #007bff; padding-left: 10px; }
    </style>
</head>
<body>
    <h1>🪪 EXAMEN PHP - DESARROLLO APLICACIONES WEB</h1>
    <p style="text-align: center; background: #e9ecef; padding: 10px; border-radius: 5px;">
        <strong>Alumno:</strong> ___________________________ 
        <strong>Fecha:</strong> <?php echo date('d/m/Y'); ?>
    </p>
    
    <!-- ==================== EJERCICIO 1 ==================== -->
    <div class="ejercicio">
        <h2>📝 EJERCICIO 1: Formulario de Registro (4 puntos)</h2>
        <p>Crear un formulario de registro con validación completa.</p>
        
        <?php if ($exitoEj1): ?>
            <div class="exito"><?php echo $exitoEj1; ?></div>
        <?php endif; ?>
        
        <form method="POST">
            <input type="hidden" name="ejercicio1" value="1">
            
            <label><strong>Nombre:</strong></label>
            <input type="text" name="nombre" placeholder="Tu nombre completo" 
                   value="<?php echo $_POST['nombre'] ?? ''; ?>" required>
            <?php if (!empty($erroresEj1['nombre'])): ?>
                <span class="error"><?php echo $erroresEj1['nombre']; ?></span>
            <?php endif; ?>
            
            <label><strong>Email:</strong></label>
            <input type="email" name="email" placeholder="tu@email.com" 
                   value="<?php echo $_POST['email'] ?? ''; ?>" required>
            <?php if (!empty($erroresEj1['email'])): ?>
                <span class="error"><?php echo $erroresEj1['email']; ?></span>
            <?php endif; ?>
            
            <label><strong>Edad:</strong></label>
            <input type="number" name="edad" placeholder="18" 
                   value="<?php echo $_POST['edad'] ?? ''; ?>" required>
            <?php if (!empty($erroresEj1['edad'])): ?>
                <span class="error"><?php echo $erroresEj1['edad']; ?></span>
            <?php endif; ?>
            
            <label><strong>Contraseña:</strong></label>
            <input type="password" name="password" placeholder="Mínimo 6 caracteres" required>
            <?php if (!empty($erroresEj1['password'])): ?>
                <span class="error"><?php echo $erroresEj1['password']; ?></span>
            <?php endif; ?>
            
            <button type="submit">Registrarse</button>
        </form>
    </div>
    
    <!-- ==================== EJERCICIO 2 ==================== -->
    <div class="ejercicio">
        <h2>📊 EJERCICIO 2: Filtrar Usuarios (3 puntos)</h2>
        <p>Filtrar usuarios mayores de 18 años con email válido.</p>
        
        <h3>Lista original de usuarios:</h3>
        <?php foreach ($usuarios as $usuario): ?>
            <div class="usuario <?php echo ($usuario['edad'] >= 18 && filter_var($usuario['email'], FILTER_VALIDATE_EMAIL)) ? 'valido' : 'invalido'; ?>">
                <strong><?php echo $usuario['nombre']; ?></strong> - 
                <?php echo $usuario['email']; ?> - 
                <?php echo $usuario['edad']; ?> años
                <?php if ($usuario['edad'] < 18): ?> ❌ Menor de edad<?php endif; ?>
                <?php if (!filter_var($usuario['email'], FILTER_VALIDATE_EMAIL)): ?> ❌ Email inválido<?php endif; ?>
            </div>
        <?php endforeach; ?>
        
        <h3>Usuarios válidos (tu función):</h3>
        <?php if (empty($usuariosValidos)): ?>
            <p>No hay usuarios válidos</p>
        <?php else: ?>
            <?php foreach ($usuariosValidos as $usuario): ?>
                <div class="usuario valido">
                    ✅ <strong><?php echo $usuario['nombre']; ?></strong> - 
                    <?php echo $usuario['email']; ?> - 
                    <?php echo $usuario['edad']; ?> años
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
    
    <!-- ==================== EJERCICIO 3 ==================== -->
    <div class="ejercicio">
        <h2>💾 EJERCICIO 3: Sistema de Contactos (3 puntos)</h2>
        <p>Guardar contactos en archivo TXT y evitar duplicados por email.</p>
        
        <?php if ($exitoEj3): ?>
            <div class="exito"><?php echo $exitoEj3; ?></div>
        <?php endif; ?>
        
        <form method="POST">
            <input type="hidden" name="ejercicio3" value="1">
            
            <label><strong>Nombre:</strong></label>
            <input type="text" name="nombre_contacto" placeholder="Tu nombre" 
                   value="<?php echo $_POST['nombre_contacto'] ?? ''; ?>" required>
            <?php if (!empty($erroresEj3['nombre_contacto'])): ?>
                <span class="error"><?php echo $erroresEj3['nombre_contacto']; ?></span>
            <?php endif; ?>
            
            <label><strong>Email:</strong></label>
            <input type="email" name="email_contacto" placeholder="tu@email.com" 
                   value="<?php echo $_POST['email_contacto'] ?? ''; ?>" required>
            <?php if (!empty($erroresEj3['email_contacto'])): ?>
                <span class="error"><?php echo $erroresEj3['email_contacto']; ?></span>
            <?php endif; ?>
            
            <label><strong>Mensaje:</strong></label>
            <textarea name="mensaje" placeholder="Escribe tu mensaje..." required><?php echo $_POST['mensaje'] ?? ''; ?></textarea>
            <?php if (!empty($erroresEj3['mensaje'])): ?>
                <span class="error"><?php echo $erroresEj3['mensaje']; ?></span>
            <?php endif; ?>
            
            <button type="submit">Guardar Contacto</button>
        </form>
        
        <h3>Contactos guardados:</h3>
        <?php echo mostrarContactos(); ?>
    </div>
    
    <!-- ==================== EJERCICIO EXTRA ==================== -->
    <div class="ejercicio">
        <h2>💬 EJERCICIO EXTRA: Sistema de Comentarios (+1 punto extra)</h2>
        <p>Crear sistema de comentarios con guardado en archivo.</p>
        
        <?php if ($exitoExtra): ?>
            <div class="exito"><?php echo $exitoExtra; ?></div>
        <?php endif; ?>
        
        <form method="POST">
            <input type="hidden" name="ejercicio_extra" value="1">
            
            <label><strong>Nombre:</strong></label>
            <input type="text" name="nombre_comentario" placeholder="Tu nombre" 
                   value="<?php echo $_POST['nombre_comentario'] ?? ''; ?>" required>
            <?php if (!empty($erroresExtra['nombre_comentario'])): ?>
                <span class="error"><?php echo $erroresExtra['nombre_comentario']; ?></span>
            <?php endif; ?>
            
            <label><strong>Email:</strong></label>
            <input type="email" name="email_comentario" placeholder="tu@email.com" 
                   value="<?php echo $_POST['email_comentario'] ?? ''; ?>" required>
            <?php if (!empty($erroresExtra['email_comentario'])): ?>
                <span class="error"><?php echo $erroresExtra['email_comentario']; ?></span>
            <?php endif; ?>
            
            <label><strong>Comentario:</strong></label>
            <textarea name="comentario" placeholder="Escribe tu comentario..." required><?php echo $_POST['comentario'] ?? ''; ?></textarea>
            <?php if (!empty($erroresExtra['comentario'])): ?>
                <span class="error"><?php echo $erroresExtra['comentario']; ?></span>
            <?php endif; ?>
            
            <button type="submit">Publicar Comentario</button>
        </form>
        
        <h3>Últimos 5 comentarios:</h3>
        <?php echo mostrarUltimosComentarios(); ?>
    </div>
    
    <footer>
        <p><strong>💡 Recordatorio:</strong> 
        Guarda este archivo como <strong>examen.php</strong> y asegúrate de que el servidor tenga permisos de escritura para crear los archivos <strong>contactos.txt</strong> y <strong>comentarios.txt</strong></p>
    </footer>
</body>
</html>