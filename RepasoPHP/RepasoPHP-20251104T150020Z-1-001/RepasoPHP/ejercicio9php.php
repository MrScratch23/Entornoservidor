<?php
// =============================================
// TU CÓDIGO PHP AQUÍ - EJERCICIO 11
// =============================================

$mensaje = "";
$imagen_subida = "";

// 1. PROCESAR FORMULARIO CON MÉTODO POST Y ARCHIVOS
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['archivo'])) {
    
    // 2. VERIFICAR SI SE SUBIÓ UN ARCHIVO
    if ($_FILES['archivo']['error'] === UPLOAD_ERR_OK) {
        $archivo = $_FILES['archivo'];
        $nombre_archivo = $archivo['name'];
        $tipo_archivo = $archivo['type'];
        $tamaño_archivo = $archivo['size'];
        $archivo_temporal = $archivo['tmp_name'];
        
        // 3. VALIDAR TIPO DE ARCHIVO (solo imágenes)
        $tipos_permitidos = ['image/jpeg', 'image/jpg', 'image/png'];
        if (!in_array($tipo_archivo, $tipos_permitidos)) {
            $mensaje = "❌ Error: Solo se permiten archivos JPEG, JPG o PNG.";
        }
        // 4. VALIDAR TAMAÑO (máximo 1MB)
        elseif ($tamaño_archivo > 1048576) { // 1MB en bytes
            $mensaje = "❌ Error: El archivo es demasiado grande. Máximo 1MB permitido.";
        } else {
            // 5. MOVER ARCHIVO AL DIRECTORIO DE DESTINO
            $directorio_destino = 'uploads/';
            
            // Crear directorio si no existe
            if (!is_dir($directorio_destino)) {
                mkdir($directorio_destino, 0755, true);
            }
            
            // Generar nombre único para evitar sobreescrituras
            $extension = pathinfo($nombre_archivo, PATHINFO_EXTENSION);
            $nuevo_nombre = uniqid() . '_' . date('Y-m-d_H-i-s') . '.' . $extension;
            $ruta_destino = $directorio_destino . $nuevo_nombre;
            
            if (move_uploaded_file($archivo_temporal, $ruta_destino)) {
                // 6. MOSTRAR IMAGEN SUBIDA Y MENSAJE DE ÉXITO
                $mensaje = "✅ Imagen subida correctamente.<br>";
                $mensaje .= "📁 Nombre: " . htmlspecialchars($nombre_archivo) . "<br>";
                $mensaje .= "📊 Tamaño: " . round($tamaño_archivo / 1024, 2) . " KB<br>";
                $mensaje .= "🎯 Tipo: " . $tipo_archivo;
                $imagen_subida = $ruta_destino;
            } else {
                $mensaje = "❌ Error: No se pudo mover el archivo al directorio de destino.";
            }
        }
    } else {
        // Manejar errores de subida
        $errores_subida = [
            UPLOAD_ERR_INI_SIZE => "El archivo excede el tamaño máximo permitido por el servidor.",
            UPLOAD_ERR_FORM_SIZE => "El archivo excede el tamaño máximo permitido por el formulario.",
            UPLOAD_ERR_PARTIAL => "El archivo fue subido parcialmente.",
            UPLOAD_ERR_NO_FILE => "No se seleccionó ningún archivo.",
            UPLOAD_ERR_NO_TMP_DIR => "No existe directorio temporal.",
            UPLOAD_ERR_CANT_WRITE => "No se pudo escribir el archivo en el disco.",
            UPLOAD_ERR_EXTENSION => "Una extensión de PHP detuvo la subida."
        ];
        
        $mensaje = "❌ Error: " . ($errores_subida[$_FILES['archivo']['error']] ?? "Error desconocido al subir el archivo.");
    }
}

// =============================================
// FIN DE TU CÓDIGO PHP
// =============================================
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Subida de Imágenes</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 40px; }
        .container { max-width: 500px; margin: 0 auto; }
        .form-group { margin: 15px 0; }
        label { display: block; margin-bottom: 5px; font-weight: bold; }
        input[type="file"] { padding: 10px; width: 100%; border: 2px solid #ddd; border-radius: 5px; }
        button { padding: 10px 20px; background: #007bff; color: white; border: none; border-radius: 5px; cursor: pointer; }
        button:hover { background: #0056b3; }
        .resultado { background: #e8f5e8; padding: 15px; border-radius: 8px; margin: 20px 0; }
        .error { background: #f8d7da; color: #721c24; padding: 15px; border-radius: 8px; }
        .imagen { max-width: 100%; margin: 15px 0; border-radius: 8px; }
    </style>
</head>
<body>
    <div class="container">
        <h1>🖼️ Subida de Imágenes</h1>
        
        <form method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="archivo">Selecciona una imagen (JPEG, JPG, PNG - máximo 1MB):</label>
                <input type="file" id="archivo" name="archivo" accept=".jpg,.jpeg,.png" required>
            </div>
            
            <button type="submit">📤 Subir Imagen</button>
        </form>
        
        <?php if ($mensaje): ?>
            <div class="<?php echo strpos($mensaje, '✅') !== false ? 'resultado' : 'error'; ?>">
                <h2>Resultado:</h2>
                <?php echo $mensaje; ?>
            </div>
        <?php endif; ?>
        
        <?php if ($imagen_subida): ?>
            <div class="imagen-container">
                <h2>Imagen Subida:</h2>
                <img src="<?php echo $imagen_subida; ?>" alt="Imagen subida" class="imagen">
            </div>
        <?php endif; ?>
    </div>
</body>
</html>