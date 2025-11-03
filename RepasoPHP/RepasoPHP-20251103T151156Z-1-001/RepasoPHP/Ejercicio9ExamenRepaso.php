<?php
// ==================== EXAMEN PHP - PRIMER TRIMESTRE DAW ====================
// ALUMNO: ___________________________ FECHA: ___________________

// ==================== EJERCICIO 1: VALIDACIÓN DE FORMULARIO ====================
$erroresEj1 = [];
$exitoEj1 = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['ejercicio1'])) {
    // TU CÓDIGO AQUÍ: Sanitizar y validar los datos del formulario de registro
    
    // 1. Sanitizar datos (nombre, email, edad, password)
    $nombre = isset($_POST['nombre']) ? htmlspecialchars($_POST['nombre']) : '';
    $email = isset($_POST['email']) ? htmlspecialchars($_POST['email']) : '';
    $edad = isset($_POST['edad']) ? ($_POST['edad']) : '';
    $password = isset($_POST['password']) ?($_POST['password']) : '';

    // 2. Validaciones:
    //    - Nombre: requerido y mínimo 2 caracteres
    //    - Email: formato válido
    //    - Edad: número entre 18 y 99
    //    - Password: mínimo 6 caracteres
    
    if (empty($nombre)) {
        $erroresEj1['nombre']="El nombre no puede estar vacio.";
    } elseif (strlen($nombre) <2) {
        $erroresEj1['nombre'] = "Minimo dos caracteres. ";
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)){
        $erroresEj1['email'] = "Tipo de email incorrecto. ";
    }

    if (!is_numeric($edad) || empty($edad)) {
        $erroresEj1['edad'] = "Introduzca una edad. ";
    } elseif ($edad <18 || $edad > 99) {
        $erroresEj1['edad'] = "Edad fuera de rango: (18-99)";
    }

    $longitudpw = strlen($password);
    if ($longitudpw <6) {
        $erroresEj1['password'] = "La contraseña debe tener mas de seis caracteres. ";
    }


    // 3. Si no hay errores, mostrar mensaje de éxito

    if (empty($erroresEj1)) {
        $exitoEj1 = "Usuario registrado correctamente.";
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
$erroresEj3 = [];
$exitoEj3 = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['ejercicio3'])) {
    // TU CÓDIGO AQUÍ: Procesar formulario de contactos
    
    // 1. Sanitizar datos (nombre, email, mensaje)
    
    
    // 2. Validaciones básicas
    
    // 3. Guardar en contactos.txt con formato: fecha|nombre|email|mensaje
    
    // 4. Evitar duplicados por email
    
}

function mostrarContactos() {
    // TU CÓDIGO AQUÍ: Leer contactos.txt y mostrar en una lista
    return "Aquí se mostrarán los contactos...";
}

// ==================== EJERCICIO EXTRA: SISTEMA DE COMENTARIOS ====================
$erroresExtra = [];
$exitoExtra = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['ejercicio_extra'])) {
    // TU CÓDIGO AQUÍ: Procesar comentarios
    // - Validar campos
    // - Guardar en comentarios.txt
    // - No permitir comentarios vacíos
}

function mostrarUltimosComentarios() {
    // TU CÓDIGO AQUÍ: Mostrar últimos 5 comentarios
    return "Aquí se mostrarán los últimos comentarios...";
}

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EXAMEN PHP - PRIMER TRIMESTRE DAW</title>
    <style>
        .ejercicio { margin: 30px 0; padding: 20px; border: 2px solid #333; border-radius: 10px; }
        .error { color: red; font-weight: bold; }
        .exito { color: green; font-weight: bold; }
        form { margin: 15px 0; padding: 15px; background: #f5f5f5; border-radius: 5px; }
        input, textarea, button { margin: 5px; padding: 8px; }
        button { background: #007bff; color: white; border: none; padding: 10px 15px; cursor: pointer; }
        button:hover { background: #0056b3; }
        .usuario { padding: 10px; margin: 5px; border: 1px solid #ddd; }
        .valido { background: #d4edda; }
        .invalido { background: #f8d7da; }
    </style>
</head>
<body>
    <h1>🪪 EXAMEN PHP - DESARROLLO APLICACIONES WEB</h1>
    <p><strong>Alumno:</strong> ___________________________ <strong>Fecha:</strong> <?php echo date('d/m/Y'); ?></p>
    
    <!-- ==================== EJERCICIO 1 ==================== -->
    <div class="ejercicio">
        <h2>📝 EJERCICIO 1: Formulario de Registro (4 puntos)</h2>
        <p>Crear un formulario de registro con validación completa.</p>
        
        <?php if ($erroresEj1): ?>
            <div class="error">
                <h4>Errores:</h4>
                <ul>
                    <?php foreach ($erroresEj1 as $error): ?>
                        <li><?php echo $error; ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>
        
        <?php if ($exitoEj1): ?>
            <div class="exito"><?php echo $exitoEj1; ?></div>
        <?php endif; ?>
        
        <form method="POST">
            <input type="hidden" name="ejercicio1" value="1">
            
            <label><strong>Nombre:</strong></label><br>
            <input type="text" name="nombre" placeholder="Tu nombre completo" 
                   value="<?php echo $_POST['nombre'] ?? ''; ?>" required><br>
            
            <label><strong>Email:</strong></label><br>
            <input type="email" name="email" placeholder="tu@email.com" 
                   value="<?php echo $_POST['email'] ?? ''; ?>" required><br>
            
            <label><strong>Edad:</strong></label><br>
            <input type="number" name="edad" placeholder="18" 
                   value="<?php echo $_POST['edad'] ?? ''; ?>" required><br>
            
            <label><strong>Contraseña:</strong></label><br>
            <input type="password" name="password" placeholder="Mínimo 6 caracteres" required><br>
            
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
            <p>No hay usuarios válidos o la función no está implementada</p>
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
        
        <?php if ($erroresEj3): ?>
            <div class="error">
                <h4>Errores:</h4>
                <ul>
                    <?php foreach ($erroresEj3 as $error): ?>
                        <li><?php echo $error; ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>
        
        <?php if ($exitoEj3): ?>
            <div class="exito"><?php echo $exitoEj3; ?></div>
        <?php endif; ?>
        
        <form method="POST">
            <input type="hidden" name="ejercicio3" value="1">
            
            <label><strong>Nombre:</strong></label><br>
            <input type="text" name="nombre_contacto" placeholder="Tu nombre" 
                   value="<?php echo $_POST['nombre_contacto'] ?? ''; ?>" required><br>
            
            <label><strong>Email:</strong></label><br>
            <input type="email" name="email_contacto" placeholder="tu@email.com" 
                   value="<?php echo $_POST['email_contacto'] ?? ''; ?>" required><br>
            
            <label><strong>Mensaje:</strong></label><br>
            <textarea name="mensaje" placeholder="Escribe tu mensaje..." required><?php echo $_POST['mensaje'] ?? ''; ?></textarea><br>
            
            <button type="submit">Guardar Contacto</button>
        </form>
        
        <h3>Contactos guardados:</h3>
        <?php echo mostrarContactos(); ?>
    </div>
    
    <!-- ==================== EJERCICIO EXTRA ==================== -->
    <div class="ejercicio">
        <h2>💬 EJERCICIO EXTRA: Sistema de Comentarios (+1 punto extra)</h2>
        <p>Crear sistema de comentarios con guardado en archivo.</p>
        
        <?php if ($erroresExtra): ?>
            <div class="error">
                <h4>Errores:</h4>
                <ul>
                    <?php foreach ($erroresExtra as $error): ?>
                        <li><?php echo $error; ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>
        
        <?php if ($exitoExtra): ?>
            <div class="exito"><?php echo $exitoExtra; ?></div>
        <?php endif; ?>
        
        <form method="POST">
            <input type="hidden" name="ejercicio_extra" value="1">
            
            <label><strong>Nombre:</strong></label><br>
            <input type="text" name="nombre_comentario" placeholder="Tu nombre" 
                   value="<?php echo $_POST['nombre_comentario'] ?? ''; ?>" required><br>
            
            <label><strong>Email:</strong></label><br>
            <input type="email" name="email_comentario" placeholder="tu@email.com" 
                   value="<?php echo $_POST['email_comentario'] ?? ''; ?>" required><br>
            
            <label><strong>Comentario:</strong></label><br>
            <textarea name="comentario" placeholder="Escribe tu comentario..." required><?php echo $_POST['comentario'] ?? ''; ?></textarea><br>
            
            <button type="submit">Publicar Comentario</button>
        </form>
        
        <h3>Últimos 5 comentarios:</h3>
        <?php echo mostrarUltimosComentarios(); ?>
    </div>
    
    <footer>
        <p><strong>💡 Pistas:</strong> 
        Usa filter_var() para emails, 
        file_put_contents() para guardar,
        empty() para validar campos vacíos,
        strlen() para longitud</p>
    </footer>
</body>
</html>