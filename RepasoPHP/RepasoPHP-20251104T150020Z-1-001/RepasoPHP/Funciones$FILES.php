<?php
// ==================== FUNCIONES PARA $_FILES ====================

// la ruta de archivos es ./carpeta

/**
 * Validar tipo de archivo
 */
function validarTipoArchivo($archivo, $tiposPermitidos = ['image/jpeg', 'image/png', 'image/gif']) {
    if (!isset($archivo['type'])) {
        return false;
    }
    return in_array($archivo['type'], $tiposPermitidos);
}

/**
 * Validar tamaño de archivo
 */
function validarTamañoArchivo($archivo, $tamañoMaximoMB = 5) {
    if (!isset($archivo['size'])) {
        return false;
    }
    $tamañoMaximoBytes = $tamañoMaximoMB * 1024 * 1024;
    return $archivo['size'] <= $tamañoMaximoBytes;
}


// tabla tranformacion Magnitud	Símbolo	Equivalencia
//1 Kilobyte	KB	1.024 bytes
// 1 Megabyte	MB	1.024 kilobytes
// 1 Gigabyte	GB	1.024 Megabytes
// 1 Terabyte	TB	1.024 Gigabytes


/**
 * Obtener extensión segura
 */
function obtenerExtension($nombreArchivo) {
    $extension = strtolower(pathinfo($nombreArchivo, PATHINFO_EXTENSION));
    $extensionesPermitidas = ['jpg', 'jpeg', 'png', 'gif', 'pdf', 'txt', 'doc', 'docx'];
    
    if (in_array($extension, $extensionesPermitidas)) {
        return $extension;
    }
    return false;
}



/**
 * Generar nombre único para archivo
 */
function generarNombreUnico($archivoOriginal) {
    $extension = obtenerExtension($archivoOriginal);
    if (!$extension) return false;
    
    return uniqid() . '_' . date('Y-m-d_H-i-s') . '.' . $extension;
}

// funcion mas simple y generica, con nombre unico
function subirArchivo($archivo, $carpetaDestino) {
    // Verificar que se subió correctamente
    if ($archivo['error'] !== UPLOAD_ERR_OK) {
        return false;
    }
    
   
    
    // Generar nombre único
    $extension = pathinfo($archivo['name'], PATHINFO_EXTENSION);
    $nombreUnico = uniqid() . '.' . $extension;
    $rutaDestino = $carpetaDestino . '/' . $nombreUnico;
    
    // Mover archivo y retornar true/false
    return move_uploaded_file($archivo['tmp_name'], $rutaDestino);
}

// ejemplo 

if (subirArchivo($_FILES['archivo'], './uploads')) {
    echo "✅ Archivo subido correctamente";
} else {
    echo "❌ Error al subir el archivo";
}


/**
 * Subir archivo con validaciones completas
 */




function subirArchivoSeguro($archivo, $carpetaDestino, $opciones = []) {
    // Opciones por defecto
    $opciones = array_merge([
        'tipos_permitidos' => ['image/jpeg', 'image/png', 'image/gif', 'application/pdf'],
        'tamaño_maximo_mb' => 5,
        'sobrescribir' => false,
        'generar_nombre_unico' => true
    ], $opciones);
    
    // Verificar errores de subida
    if ($archivo['error'] !== UPLOAD_ERR_OK) {
        return [
            'exito' => false,
            'mensaje' => 'Error al subir el archivo: ' . obtenerMensajeError($archivo['error'])
        ];
    }
    
    // Validar tipo
    if (!validarTipoArchivo($archivo, $opciones['tipos_permitidos'])) {
        return [
            'exito' => false,
            'mensaje' => 'Tipo de archivo no permitido'
        ];
    }
    
    // Validar tamaño
    if (!validarTamañoArchivo($archivo, $opciones['tamaño_maximo_mb'])) {
        return [
            'exito' => false,
            'mensaje' => 'El archivo es demasiado grande'
        ];
    }
    
    // Crear carpeta si no existe
    if (!is_dir($carpetaDestino)) {
        if (!mkdir($carpetaDestino, 0755, true)) {
            return [
                'exito' => false,
                'mensaje' => 'No se pudo crear la carpeta destino'
            ];
        }
    }
    
    // Generar nombre del archivo
    if ($opciones['generar_nombre_unico']) {
        $nombreArchivo = generarNombreUnico($archivo['name']);
        if (!$nombreArchivo) {
            return [
                'exito' => false,
                'mensaje' => 'Extensión de archivo no permitida'
            ];
        }
    } else {
        $nombreArchivo = basename($archivo['name']);
    }
    
    $rutaDestino = $carpetaDestino . '/' . $nombreArchivo;
    
    // Verificar si ya existe
    if (!$opciones['sobrescribir'] && file_exists($rutaDestino)) {
        return [
            'exito' => false,
            'mensaje' => 'El archivo ya existe'
        ];
    }
    
    // Mover archivo
    if (move_uploaded_file($archivo['tmp_name'], $rutaDestino)) {
        return [
            'exito' => true,
            'mensaje' => 'Archivo subido correctamente',
            'ruta' => $rutaDestino,
            'nombre' => $nombreArchivo
        ];
    } else {
        return [
            'exito' => false,
            'mensaje' => 'Error al mover el archivo'
        ];
    }
}

/**
 * Obtener mensaje de error legible
 */
function obtenerMensajeError($codigoError) {
    $errores = [
        UPLOAD_ERR_OK => 'No hay error',
        UPLOAD_ERR_INI_SIZE => 'El archivo excede el tamaño permitido',
        UPLOAD_ERR_FORM_SIZE => 'El archivo excede el tamaño del formulario',
        UPLOAD_ERR_PARTIAL => 'El archivo fue subido parcialmente',
        UPLOAD_ERR_NO_FILE => 'No se subió ningún archivo',
        UPLOAD_ERR_NO_TMP_DIR => 'Falta la carpeta temporal',
        UPLOAD_ERR_CANT_WRITE => 'No se pudo escribir en el disco',
        UPLOAD_ERR_EXTENSION => 'Extensión de PHP detuvo la subida'
    ];
    
    return $errores[$codigoError] ?? 'Error desconocido';
}

/**
 * Procesar múltiples archivos
 */
function procesarArchivosMultiples($archivos, $carpetaDestino, $opciones = []) {
    $resultados = [];
    
    if (is_array($archivos['name'])) {
        foreach ($archivos['name'] as $key => $name) {
            if ($archivos['error'][$key] === UPLOAD_ERR_OK) {
                $archivoIndividual = [
                    'name' => $archivos['name'][$key],
                    'type' => $archivos['type'][$key],
                    'tmp_name' => $archivos['tmp_name'][$key],
                    'error' => $archivos['error'][$key],
                    'size' => $archivos['size'][$key]
                ];
                
                $resultados[] = subirArchivoSeguro($archivoIndividual, $carpetaDestino, $opciones);
            }
        }
    } else {
        $resultados[] = subirArchivoSeguro($archivos, $carpetaDestino, $opciones);
    }
    
    return $resultados;
}

/**
 * Obtener información del archivo
 */
function obtenerInfoArchivo($archivo) {
    return [
        'nombre_original' => $archivo['name'],
        'tipo_mime' => $archivo['type'],
        'tamaño_bytes' => $archivo['size'],
        'extension' => obtenerExtension($archivo['name']),
        'nombre_temporal' => $archivo['tmp_name']
    ];
}

/**
 * Verificar si es imagen
 */
function esImagen($archivo) {
    $tiposImagen = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
    return in_array($archivo['type'], $tiposImagen);
}

/**
 * Eliminar archivo subido
 */
function eliminarArchivo($rutaArchivo) {
    if (file_exists($rutaArchivo) && is_file($rutaArchivo)) {
        return unlink($rutaArchivo);
    }
    return false;
}

// ==================== FUNCIONES PARA MOSTRAR ARCHIVOS ====================

/**
 * Mostrar imagen subida
 */
function mostrarImagen($rutaImagen, $ancho = 200, $alt = 'Imagen subida') {
    if (file_exists($rutaImagen)) {
        return "<img src='$rutaImagen' width='$ancho' alt='$alt'>";
    }
    return "<p>Imagen no encontrada</p>";
}

/**
 * Mostrar información de archivo
 */
function mostrarInfoArchivo($archivo) {
    $info = obtenerInfoArchivo($archivo);
    $html = '<div class="info-archivo">';
    $html .= '<h4>Información del Archivo:</h4>';
    $html .= '<ul>';
    $html .= "<li><strong>Nombre:</strong> {$info['nombre_original']}</li>";
    $html .= "<li><strong>Tipo:</strong> {$info['tipo_mime']}</li>";
    $html .= "<li><strong>Tamaño:</strong> {$info['tamaño_bytes']} bytes</li>";
    $html .= "<li><strong>Extensión:</strong> {$info['extension']}</li>";
    $html .= '</ul>';
    $html .= '</div>';
    return $html;
}

/**
 * Mostrar resultado de subida
 */
function mostrarResultadoSubida($resultado) {
    if ($resultado['exito']) {
        return "<div style='color: green; padding: 10px; border: 1px solid green;'>
                ✅ {$resultado['mensaje']}<br>
                📁 Archivo: {$resultado['nombre']}<br>
                📍 Ruta: {$resultado['ruta']}
                </div>";
    } else {
        return "<div style='color: red; padding: 10px; border: 1px solid red;'>
                ❌ {$resultado['mensaje']}
                </div>";
    }
}

// ==================== EJEMPLOS DE USO ====================

/*
// EJEMPLO 1: Subir imagen con validaciones
if ($_FILES && isset($_FILES['imagen_perfil'])) {
    $resultado = subirArchivoSeguro($_FILES['imagen_perfil'], 'uploads/imagenes', [
        'tipos_permitidos' => ['image/jpeg', 'image/png'],
        'tamaño_maximo_mb' => 2
    ]);
    
    echo mostrarResultadoSubida($resultado);
    
    if ($resultado['exito']) {
        echo mostrarImagen($resultado['ruta']);
        echo mostrarInfoArchivo($_FILES['imagen_perfil']);
    }
}

// EJEMPLO 2: Subir múltiples archivos
if ($_FILES && isset($_FILES['documentos'])) {
    $resultados = procesarArchivosMultiples($_FILES['documentos'], 'uploads/documentos', [
        'tipos_permitidos' => ['application/pdf', 'text/plain'],
        'tamaño_maximo_mb' => 5
    ]);
    
    foreach ($resultados as $resultado) {
        echo mostrarResultadoSubida($resultado);
    }
}

// EJEMPLO 3: Subir archivo con nombre original
if ($_FILES && isset($_FILES['contrato'])) {
    $resultado = subirArchivoSeguro($_FILES['contrato'], 'uploads/contratos', [
        'generar_nombre_unico' => false,
        'sobrescribir' => true
    ]);
    
    echo mostrarResultadoSubida($resultado);
}

// EJEMPLO 4: Validar antes de subir
if ($_FILES && isset($_FILES['archivo'])) {
    $archivo = $_FILES['archivo'];
    
    if (!validarTipoArchivo($archivo, ['image/jpeg', 'image/png'])) {
        echo "❌ Solo se permiten imágenes JPG y PNG";
    } elseif (!validarTamañoArchivo($archivo, 3)) {
        echo "❌ El archivo debe ser menor a 3MB";
    } else {
        $resultado = subirArchivoSeguro($archivo, 'uploads');
        echo mostrarResultadoSubida($resultado);
    }
}

// EJEMPLO 5: Eliminar archivo subido
$archivoAEliminar = 'uploads/imagen_vieja.jpg';
if (eliminarArchivo($archivoAEliminar)) {
    echo "✅ Archivo eliminado correctamente";
} else {
    echo "❌ No se pudo eliminar el archivo";
}

// EJEMPLO 6: Verificar si es imagen
if ($_FILES && isset($_FILES['foto'])) {
    if (esImagen($_FILES['foto'])) {
        echo "🖼️ Es una imagen válida";
        $resultado = subirArchivoSeguro($_FILES['foto'], 'uploads/fotos');
        echo mostrarResultadoSubida($resultado);
    } else {
        echo "❌ El archivo no es una imagen válida";
    }
}

// HTML DE EJEMPLO:
?>
<form method="POST" enctype="multipart/form-data">
    <h3>Subir Imagen de Perfil:</h3>
    <input type="file" name="imagen_perfil" accept="image/jpeg, image/png" required>
    <button type="submit">Subir Imagen</button>
</form>

<form method="POST" enctype="multipart/form-data">
    <h3>Subir Múltiples Documentos:</h3>
    <input type="file" name="documentos[]" multiple accept=".pdf,.txt" required>
    <button type="submit">Subir Documentos</button>
</form>

<form method="POST" enctype="multipart/form-data">
    <h3>Subir Contrato (conservar nombre):</h3>
    <input type="file" name="contrato" accept=".pdf,.doc,.docx" required>
    <button type="submit">Subir Contrato</button>
</form>
*/
?>