<?php
// ==================== FUNCIONES PARA ARRAYS INDEXADOS ====================

function eliminarDelArray(&$array, $valor) {
    $clave = array_search($valor, $array, true);
    if ($clave !== false) {
        unset($array[$clave]);
        $array = array_values($array);
        return true;
    }
    return false;
}

// Guardar array indexado en TXT
function guardarArrayIndexadoTXT($archivo, $arrayIndexado) {
    file_put_contents($archivo, implode("\n", $arrayIndexado));
    return true;
}

// Guardar array indexado en CSV
function guardarArrayIndexadoCSV($archivo, $arrayIndexado) {
    $handle = fopen($archivo, 'a');
    fputcsv($handle, $arrayIndexado);
    fclose($handle);
    return true;
}

// ==================== FUNCIONES PARA ARRAYS ASOCIATIVOS ====================

function eliminarClaveArray(&$array, $clave) {
    if (isset($array[$clave])) {
        unset($array[$clave]);
        return true;
    }
    return false;
}

/**
 * Borrar un valor específico de un array asociativo (busca y elimina por valor)
 * Elimina todas las claves que contengan ese valor
 */
function borrarValorArray(&$arrayAsociativo, $valor) {
    $clave = array_search($valor, $arrayAsociativo, true);
    if ($clave !== false) {
        unset($arrayAsociativo[$clave]);
        return true;
    }
    return false;
}

/**
 * Borrar todas las ocurrencias de un valor en un array asociativo
 * (si el valor aparece múltiples veces, elimina todas las claves)
 */
function borrarTodasOcurrenciasValor(&$arrayAsociativo, $valor) {
    $borrados = 0;
    foreach ($arrayAsociativo as $clave => $valorActual) {
        if ($valorActual === $valor) {
            unset($arrayAsociativo[$clave]);
            $borrados++;
        }
    }
    return $borrados;
}

function guardarArrayAsociativoTXT($archivo, $arrayAsociativo) {
    $lineas = [];
    foreach ($arrayAsociativo as $clave => $valor) {
        $lineas[] = "$clave: $valor";
    }
    file_put_contents($archivo, implode("\n", $lineas));
    return true;
}

function guardarArrayAsociativoCSV($archivo, $arrayAsociativo) {
    $handle = fopen($archivo, 'a');
    if (filesize($archivo) == 0) {
        fputcsv($handle, array_keys($arrayAsociativo));
    }
    fputcsv($handle, array_values($arrayAsociativo));
    fclose($handle);
    return true;
}

// ==================== FUNCIONES PARA ARCHIVOS TXT ====================

function eliminarLineaArchivo($archivo, $contenidoEliminar) {
    $lineas = file($archivo, FILE_IGNORE_NEW_LINES);
    $clave = array_search($contenidoEliminar, $lineas);
    if ($clave !== false) {
        unset($lineas[$clave]);
        file_put_contents($archivo, implode("\n", $lineas));
        return true;
    }
    return false;
}

// ==================== FUNCIONES PARA ARCHIVOS CSV ====================

function eliminarFilaCSV($archivo, $valorBuscar) {
    $filas = [];
    $handle = fopen($archivo, 'r');
    while ($data = fgetcsv($handle)) {
        $filas[] = $data;
    }
    fclose($handle);
    
    foreach ($filas as $clave => $fila) {
        if (in_array($valorBuscar, $fila)) {
            unset($filas[$clave]);
            break;
        }
    }
    
    $handle = fopen($archivo, 'w');
    foreach ($filas as $fila) {
        fputcsv($handle, $fila);
    }
    fclose($handle);
    return true;
}

function valorExiste($archivo, $valor) {
    if (!file_exists($archivo)) return false;
    
    $handle = fopen($archivo, 'r');
    while ($data = fgetcsv($handle)) {
        if (in_array($valor, $data)) {
            fclose($handle);
            return true;
        }
    }
    fclose($handle);
    return false;
}

// ==================== FUNCIONES PARA MOSTRAR EN LISTAS ====================

function arrayALista($array, $titulo = '') {
    if (empty($array)) return "<p>No hay datos</p>";
    
    $html = '';
    if ($titulo) {
        $html .= "<h3>$titulo</h3>";
    }
    
    $html .= '<ul>';
    
    if (array_is_list($array)) {
        foreach ($array as $valor) {
            $html .= "<li>$valor</li>";
        }
    } else {
        foreach ($array as $clave => $valor) {
            $html .= "<li><strong>$clave:</strong> $valor</li>";
        }
    }
    
    $html .= '</ul>';
    return $html;
}

function txtALista($archivo, $titulo = '') {
    if (!file_exists($archivo)) return "<p>Archivo no encontrado</p>";
    
    $lineas = file($archivo, FILE_IGNORE_NEW_LINES);
    if (empty($lineas)) return "<p>Archivo vacío</p>";
    
    $html = '';
    if ($titulo) {
        $html .= "<h3>$titulo</h3>";
    }
    
    $html .= '<ul>';
    foreach ($lineas as $linea) {
        if (trim($linea) !== '') {
            $html .= "<li>$linea</li>";
        }
    }
    $html .= '</ul>';
    return $html;
}


function csvALista($archivo, $titulo = '') {
    if (!file_exists($archivo)) return "<p>Archivo no encontrado</p>";
    
    $html = '';
    if ($titulo) {
        $html .= "<h3>$titulo</h3>";
    }
    
    $html .= '<ul>';
    $handle = fopen($archivo, 'r');
    
    while ($data = fgetcsv($handle)) {
        $html .= "<li>" . implode(" - ", $data) . "</li>";
    }
    
    fclose($handle);
    $html .= '</ul>';
    return $html;
}

// ==================== FUNCIONES PARA MOSTRAR EN TABLAS ====================

function arrayATabla($array, $titulo = '') {
    if (empty($array)) return "<p>No hay datos</p>";
    
    $html = '';
    if ($titulo) {
        $html .= "<h3>$titulo</h3>";
    }
    
    $html .= '<table border="1">';
    
    if (array_is_list($array)) {
        foreach ($array as $fila) {
            $html .= '<tr>';
            if (is_array($fila)) {
                foreach ($fila as $valor) {
                    $html .= "<td>$valor</td>";
                }
            } else {
                $html .= "<td>$fila</td>";
            }
            $html .= '</tr>';
        }
    } else {
        $html .= '<tr>';
        foreach (array_keys($array) as $header) {
            $html .= "<th>$header</th>";
        }
        $html .= '</tr>';
        $html .= '<tr>';
        foreach ($array as $valor) {
            $html .= "<td>$valor</td>";
        }
        $html .= '</tr>';
    }
    
    $html .= '</table>';
    return $html;
}

function csvATabla($archivo, $titulo = '') {
    if (!file_exists($archivo)) return "<p>Archivo no encontrado</p>";
    
    $html = '';
    if ($titulo) {
        $html .= "<h3>$titulo</h3>";
    }
    
    $html .= '<table border="1">';
    
    $handle = fopen($archivo, 'r');
    $esPrimeraLinea = true;
    
    while ($data = fgetcsv($handle)) {
        $html .= '<tr>';
        foreach ($data as $valor) {
            if ($esPrimeraLinea) {
                $html .= "<th>$valor</th>";
            } else {
                $html .= "<td>$valor</td>";
            }
        }
        $html .= '</tr>';
        $esPrimeraLinea = false;
    }
    
    fclose($handle);
    $html .= '</table>';
    return $html;
}

// ==================== FUNCIÓN PARA SUBIR ARCHIVOS ====================

function subirArchivo($archivo, $carpetaDestino, $nuevoNombre = null) {
    if ($archivo['error'] !== UPLOAD_ERR_OK) {
        return "Error en la subida";
    }
    
    $nombreFinal = $nuevoNombre ?: $archivo['name'];
    $rutaDestino = $carpetaDestino . '/' . $nombreFinal;
    
    if (move_uploaded_file($archivo['tmp_name'], $rutaDestino)) {
        return $rutaDestino;
    }
    return false;
}

// subir archivo creadno tambien carpeta + nombre aleatorio
function subirArchivoComprobandoDir($archivo, $carpetaDestino = 'archivos') {
    // Verificar si el archivo se subió correctamente
    if ($archivo['error'] !== UPLOAD_ERR_OK) {
        return "Error: No se pudo subir el archivo";
    }
    
    $nombreArchivo = basename($archivo['name']);
    $rutaCompleta = $carpetaDestino . '/' . $nombreArchivo;
    
    // Crear carpeta si no existe
    if (!is_dir($carpetaDestino)) {
        mkdir($carpetaDestino, 0755, true);
    }
    
    // Si el archivo ya existe, generar nuevo nombre
    if (file_exists($rutaCompleta)) {
        $extension = pathinfo($nombreArchivo, PATHINFO_EXTENSION);
        $nombreBase = pathinfo($nombreArchivo, PATHINFO_FILENAME);
        $nuevoNombre = $nombreBase . '_' . date('Y-m-d_H-i-s') . '.' . $extension;
        $rutaCompleta = $carpetaDestino . '/' . $nuevoNombre;
    }
    
    // Mover el archivo
    if (move_uploaded_file($archivo['tmp_name'], $rutaCompleta)) {
        return "Archivo subido: " . basename($rutaCompleta);
    } else {
        return "Error: No se pudo guardar el archivo";
    }
}


// como mostrar una imagen

function mostrarPersonajeConImagen($personaje) {
    echo "<h2>¡Personaje Creado!</h2>";
    echo "<p><strong>Nombre:</strong> " . $personaje['nombre'] . "</p>";
    echo "<p><strong>Nivel:</strong> " . $personaje['nivel'] . "</p>";
    echo "<p><strong>Clase:</strong> " . $personaje['clase'] . "</p>";
    echo "<p><strong>Vida:</strong> " . $personaje['vida'] . "</p>";
    echo "<p><strong>Ataque:</strong> " . $personaje['ataque'] . "</p>";
    echo "<p><strong>Defensa:</strong> " . $personaje['defensa'] . "</p>";
    
    // Esto sí muestra la imagen real
    echo "<p><strong>Imagen:</strong></p>";
    echo "<img src='imagenes_personajes/" . $personaje['imagen'] . "' width='200'>";
}

// ==================== EJEMPLOS DE USO ====================

/*
// Definir carpeta
$carpeta = "/carpeta";

// ARRAYS INDEXADOS
$frutas = ['manzana', 'banana', 'naranja'];
eliminarDelArray($frutas, 'banana');
guardarArrayIndexadoTXT('frutas.txt', $frutas);
guardarArrayIndexadoCSV('frutas.csv', $frutas);

// ARRAYS ASOCIATIVOS
$usuario = ['nombre' => 'Juan', 'email' => 'juan@email.com', 'edad' => 25];
eliminarClaveArray($usuario, 'edad');
borrarValorArray($usuario, 'juan@email.com'); // Nueva función añadida
guardarArrayAsociativoTXT('usuario.txt', $usuario);
guardarArrayAsociativoCSV('usuarios.csv', $usuario);

// ARCHIVOS
eliminarLineaArchivo('notas.txt', 'texto a borrar');
eliminarFilaCSV('datos.csv', 'valor a eliminar');

// VERIFICAR
if (valorExiste('usuarios.csv', 'juan@email.com')) {
    echo "El valor ya existe";
}

// MOSTRAR
$mensaje = arrayALista($frutas, 'Frutas');
$mensaje .= arrayALista($usuario, 'Usuario');
$mensaje .= arrayATabla($frutas, 'Frutas Tabla');
$mensaje .= arrayATabla($usuario, 'Usuario Tabla');

// SUBIR ARCHIVOS
subirArchivo($_FILES['archivo'], $carpeta, 'nuevo_nombre');
*/
?>