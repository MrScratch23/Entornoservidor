<?php
// =============================================
// TU CÓDIGO PHP AQUÍ - EJERCICIO 11
// =============================================

$mensaje = "";
$imagen_subida = "";

// 1. PROCESAR FORMULARIO CON MÉTODO POST Y ARCHIVOS


// 2. VERIFICAR SI SE SUBIÓ UN ARCHIVO


// 3. VALIDAR TIPO DE ARCHIVO (solo imágenes)


// 4. VALIDAR TAMAÑO (máximo 1MB)


// 5. MOVER ARCHIVO AL DIRECTORIO DE DESTINO


// 6. MOSTRAR IMAGEN SUBIDA Y MENSAJE DE ÉXITO


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