<?php
// Archivo donde se guardarán los usuarios
$archivo_usuarios = 'usuarios.txt';

// Procesar el formulario cuando se envía
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = trim($_POST['nombre'] ?? '');
    $email = trim($_POST['email'] ?? '');
    
    if (!empty($nombre) && !empty($email)) {
        // Formatear los datos
        $datos_usuario = date('Y-m-d H:i:s') . " | " . 
                        htmlspecialchars($nombre) . " | " . 
                        htmlspecialchars($email) . "\n";
        
        // Abrir y guardar en el archivo
        $archivo = fopen($archivo_usuarios, 'a');
        fwrite($archivo, $datos_usuario);
        fclose($archivo);
    }
}

// Leer y mostrar usuarios
$usuarios = [];
if (file_exists($archivo_usuarios)) {
    $contenido = file_get_contents($archivo_usuarios);
    $lineas = explode("\n", $contenido);
    
    foreach ($lineas as $linea) {
        $linea = trim($linea);
        if (!empty($linea)) {
            $usuarios[] = $linea;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Usuarios</title>
    <style>
        body { font-family: Arial, sans-serif; max-width: 800px; margin: 0 auto; padding: 20px; }
        .form-container { background: #f5f5f5; padding: 20px; border-radius: 8px; margin-bottom: 30px; }
        .form-group { margin-bottom: 15px; }
        label { display: block; margin-bottom: 5px; font-weight: bold; }
        input[type="text"], input[type="email"] { width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px; }
        button { background: #007bff; color: white; padding: 10px 20px; border: none; border-radius: 4px; cursor: pointer; }
        button:hover { background: #0056b3; }
        .lista-usuarios { margin-top: 30px; }
        .usuario-item { background: white; padding: 15px; margin-bottom: 10px; border-radius: 4px; border-left: 4px solid #007bff; }
        .contador { background: #28a745; color: white; padding: 5px 10px; border-radius: 4px; display: inline-block; margin-bottom: 10px; }
    </style>
</head>
<body>
    <h1>Registro de Usuarios</h1>
    
    <div class="form-container">
        <h2>Agregar Nuevo Usuario</h2>
        <form method="POST">
            <div class="form-group">
                <label for="nombre">Nombre:</label>
                <input type="text" id="nombre" name="nombre" required>
            </div>
            
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>
            </div>
            
            <button type="submit">Registrar Usuario</button>
        </form>
    </div>

    <div class="lista-usuarios">
        <h2>Usuarios Registrados 
            <span class="contador">Total: <?php echo count($usuarios); ?></span>
        </h2>
        
        <?php if (empty($usuarios)): ?>
            <p>No hay usuarios registrados aún.</p>
        <?php else: ?>
            <?php foreach (array_reverse($usuarios) as $usuario): ?>
                <div class="usuario-item">
                    <?php 
                    $partes = explode(' | ', $usuario);
                    if (count($partes) >= 3) {
                        echo "<strong>Fecha:</strong> " . $partes[0] . "<br>";
                        echo "<strong>Nombre:</strong> " . $partes[1] . "<br>";
                        echo "<strong>Email:</strong> " . $partes[2];
                    }
                    ?>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</body>
</html>