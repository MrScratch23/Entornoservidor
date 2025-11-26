<?php

/// VALIDACIONES

function validarEmail($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
}

function validarNumero($numero, $min = null, $max = null) {
    if (!is_numeric($numero)) return false;
    if ($min !== null && $numero < $min) return false;
    if ($max !== null && $numero > $max) return false;
    return true;
}

// ==================== FUNCIONES PARA ARRAYS INDEXADOS ====================

// para indexado txt
function leerArchivoIndexado($archivo, $delimitador = '|') {
    if (!file_exists($archivo)) return [];
    
    $manejador = fopen($archivo, "r");
    if (!$manejador) return [];
    
    $datos = [];
    
    while (!feof($manejador)) {
        $linea = fgets($manejador);
        if ($linea === false) continue;
        
        $linea = trim($linea);
        if (empty($linea)) continue;
        
        $partes = explode($delimitador, $linea);
        
        // ✅ GENÉRICO: Devuelve array indexado simple
        $datos[] = $partes;
    }
    
    fclose($manejador);
    return $datos;
}

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
function guardarArrayIndexadoTXT($archivo, $arrayIndexado, $delimitador = "\n") {
    file_put_contents($archivo, implode($delimitador, $arrayIndexado));
    return true;
}

// Guardar array indexado en CSV
function guardarArrayIndexadoCSV($archivo, $arrayIndexado, $delimitador = ",") {
    $handle = @fopen($archivo, 'a');
    fputcsv($handle, $arrayIndexado, $delimitador);
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

function borrarClaveArray(&$arrayAsociativo, $clave) {
    if (array_key_exists($clave, $arrayAsociativo)) {
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

function guardarArrayAsociativoTXT($archivo, $arrayAsociativo, $delimitador = ": ") {
    $lineas = [];
    foreach ($arrayAsociativo as $clave => $valor) {
        $lineas[] = "$clave$delimitador$valor";
    }
    file_put_contents($archivo, implode("\n", $lineas));
    return true;
}

function guardarArrayAsociativoCSV($archivo, $arrayAsociativo, $delimitador = ",") {
    $handle = fopen($archivo, 'a');
    if (filesize($archivo) == 0) {
        fputcsv($handle, array_keys($arrayAsociativo), $delimitador);
    }
    fputcsv($handle, array_values($arrayAsociativo), $delimitador);
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

function eliminarFilaCSV($archivo, $valorBuscar, $delimitador = ",") {
    $filas = [];
    $handle = fopen($archivo, 'r');
    while ($data = fgetcsv($handle, 0, $delimitador)) {
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
        fputcsv($handle, $fila, $delimitador);
    }
    fclose($handle);
    return true;
}

function valorExiste($archivo, $valor, $delimitador = ",") {
    if (!file_exists($archivo)) return false;
    
    $handle = fopen($archivo, 'r');
    while ($data = fgetcsv($handle, 0, $delimitador)) {
        if (in_array($valor, $data)) {
            fclose($handle);
            return true;
        }
    }
    fclose($handle);
    return false;
}

function cargarDatosSUPER($archivo, $formato = 'indexado', $delimitador = ',')
{
    $datos = [];
    if (!file_exists($archivo)) return $datos;
    
    $manejador = @fopen($archivo, "r");
    if ($manejador) {
        // Leer primera línea con el delimitador personalizado
        $primeraLinea = fgetcsv($manejador, 0, $delimitador);
        if ($primeraLinea === false) {
            fclose($manejador);
            return $datos;
        }
        
        // Verificar si la primera línea parece encabezados (no numérica)
        $tieneEncabezados = false;
        if ($formato === 'auto') {
            $tieneEncabezados = !is_numeric(trim($primeraLinea[0]));
        }
        
        // Si tiene encabezados, procesar de forma asociativa
        if ($tieneEncabezados) {
            $encabezados = $primeraLinea;
            while (!feof($manejador)) {
                $temp = fgetcsv($manejador, 0, $delimitador);
                if ($temp === false || (count($temp) === 1 && empty(trim($temp[0])))) continue;
                
                $fila = [];
                foreach ($encabezados as $index => $encabezado) {
                    $fila[trim($encabezado)] = $temp[$index] ?? '';
                }
                $datos[] = $fila;
            }
        } else {
            // Si no tiene encabezados, procesar como indexado
            $datos[] = $primeraLinea; // Guardar la primera línea también
            while (!feof($manejador)) {
                $temp = fgetcsv($manejador, 0, $delimitador);
                if ($temp === false || (count($temp) === 1 && empty(trim($temp[0])))) continue;
                $datos[] = $temp;
            }
        }
        
        fclose($manejador);
    }
    return $datos;
}

// en prueba

function cargarArchivoUniversal($archivo, $delimitador = ',', $usarFgetcsv = 'auto') 
{
    if (!file_exists($archivo)) return [];
    
    // Detectar automáticamente si necesita fgetcsv
    if ($usarFgetcsv === 'auto') {
        $contenido = file_get_contents($archivo);
        $usarFgetcsv = (strpos($contenido, '"') !== false) ? true : false;
    }
    
    if ($usarFgetcsv) {
        return cargarConFgetcsv($archivo, $delimitador);
    } else {
        return cargarConExplode($archivo, $delimitador);
    }
}

function cargarConFgetcsv($archivo, $delimitador) {
    $manejador = fopen($archivo, "r");
    $datos = [];
    
    while (!feof($manejador)) {
        $fila = fgetcsv($manejador, 0, $delimitador);
        if ($fila !== false && !empty(array_filter($fila))) {
            $datos[] = $fila;
        }
    }
    
    fclose($manejador);
    return $datos;
}

function cargarConExplode($archivo, $delimitador) {
    $lineas = file($archivo, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    $datos = [];
    
    foreach ($lineas as $linea) {
        $datos[] = explode($delimitador, trim($linea));
    }
    
    return $datos;
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
    
    $lineas = file($archivo); 
    if (empty($lineas)) return "<p>Archivo vacío</p>";
    
    $html = '';
    if ($titulo) {
        $html .= "<h3>$titulo</h3>";
    }
    
    $html .= '<ul>';
    foreach ($lineas as $linea) {
        $linea = trim($linea); // Elimina saltos de línea y espacios
        if ($linea !== '') {
            $html .= "<li>$linea</li>";
        }
    }
    $html .= '</ul>';
    return $html;
}

function csvALista($archivo, $titulo = '', $delimitador = ",") {
    if (!file_exists($archivo)) return "<p>Archivo no encontrado</p>";
    
    $html = '';
    if ($titulo) {
        $html .= "<h3>$titulo</h3>";
    }
    
    $html .= '<ul>';
    $handle = fopen($archivo, 'r');
    
    while ($data = fgetcsv($handle, 0, $delimitador)) {
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
    
    $html .= '<table border="1" style="border-collapse: collapse; width: 100%;">';
    
    // Detectar si es array de arrays
    $esMultidimensional = is_array($array[0] ?? null);
    
    if ($esMultidimensional) {
        // Generar encabezados desde las keys del primer elemento
        $html .= '<tr>';
        foreach (array_keys($array[0]) as $header) {
            $html .= "<th style='padding: 8px; background: #f0f0f0;'>" . htmlspecialchars($header) . "</th>";
        }
        $html .= '</tr>';
        
        // Generar filas
        foreach ($array as $fila) {
            $html .= '<tr>';
            foreach ($fila as $valor) {
                $html .= "<td style='padding: 8px;'>" . htmlspecialchars($valor) . "</td>";
            }
            $html .= '</tr>';
        }
    } else {
        // Array simple
        $html .= '<tr>';
        foreach ($array as $valor) {
            $html .= "<td style='padding: 8px;'>" . htmlspecialchars($valor) . "</td>";
        }
        $html .= '</tr>';
    }
    
    $html .= '</table>';
    return $html;
}

function csvATabla($archivo, $titulo = '', $delimitador = ",") {
    if (!file_exists($archivo)) return "<p>Archivo no encontrado</p>";
    
    $html = '';
    if ($titulo) {
        $html .= "<h3>$titulo</h3>";
    }
    
    $html .= '<table border="1">';
    
    $handle = fopen($archivo, 'r');
    $esPrimeraLinea = true;
    
    while ($data = fgetcsv($handle, 0, $delimitador)) {
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

// subir archivo + nombre aleatorio
function subirArchivo($archivo, $carpetaDestino, $nuevoNombre = null) {
    if ($archivo['error'] !== UPLOAD_ERR_OK) {
        return "Error en la subida";
    }
    
    $nombreFinal = $nuevoNombre ?: $archivo['name'];
    $rutaDestino = $carpetaDestino . '/' . $nombreFinal;
    
    // Si el archivo ya existe, generar nuevo nombre
    if (file_exists($rutaDestino)) {
        $extension = pathinfo($nombreFinal, PATHINFO_EXTENSION);
        $nombreBase = pathinfo($nombreFinal, PATHINFO_FILENAME);
        $nuevoNombre = $nombreBase . '_' . date('Y-m-d_H-i-s') . '.' . $extension;
        $rutaDestino = $carpetaDestino . '/' . $nuevoNombre;
    }
    
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

// ==================== FUNCIONES PARA VALORES ALEATORIOS ====================

/**
 * Obtiene un valor aleatorio de un array indexado
 */
function valorAleatorio($array) {
    if (empty($array)) {
        return null;
    }
    
    $indiceAleatorio = array_rand($array);
    return $array[$indiceAleatorio];
}

/**
 * Obtiene un valor aleatorio de un array asociativo
 */
function valorAleatorioAsociativo($array) {
    if (empty($array)) {
        return null;
    }
    
    $claves = array_keys($array);
    $claveAleatoria = $claves[array_rand($claves)];
    return $array[$claveAleatoria];
}

/**
 * Obtiene múltiples valores aleatorios de un array (sin repetición)
 */
function valoresAleatorios($array, $cantidad = 1) {
    if (empty($array) || $cantidad <= 0) {
        return [];
    }
    
    // Si piden más elementos de los que hay, devolvemos todos
    if ($cantidad >= count($array)) {
        return array_values($array);
    }
    
    $indicesAleatorios = array_rand($array, $cantidad);
    
    // array_rand devuelve un solo índice si $cantidad es 1
    if ($cantidad == 1) {
        return [$array[$indicesAleatorios]];
    }
    
    $resultado = [];
    foreach ($indicesAleatorios as $indice) {
        $resultado[] = $array[$indice];
    }
    
    return $resultado;
}

// ==================== FUNCIONES CON ARRAY_FILTER ====================

/**
 * EJEMPLOS DE ARRAY_FILTER A VARIOS NIVELES
 */

// NIVEL 1: Filtrado básico
function filtrarPorValor($array, $valorBuscado) {
    return array_filter($array, function($elemento) use ($valorBuscado) {
        return $elemento === $valorBuscado;
    });
}

// NIVEL 2: Filtrado por clave en array asociativo
function filtrarPorClave($array, $claveBuscada) {
    return array_filter($array, function($valor, $clave) use ($claveBuscada) {
        return $clave === $claveBuscada;
    }, ARRAY_FILTER_USE_BOTH);
}

// NIVEL 3: Filtrado por condición en array multidimensional
function filtrarUsuariosPorRol($usuarios, $rol) {
    return array_filter($usuarios, function($usuario) use ($rol) {
        return $usuario['rol'] === $rol;
    });
}

// NIVEL 4: Filtrado con múltiples condiciones
function filtrarUsuariosAvanzado($usuarios, $filtros) {
    return array_filter($usuarios, function($usuario) use ($filtros) {
        $cumple = true;
        
        if (isset($filtros['rol']) && $usuario['rol'] !== $filtros['rol']) {
            $cumple = false;
        }
        
        if (isset($filtros['email_contiene']) && 
            strpos($usuario['email'], $filtros['email_contiene']) === false) {
            $cumple = false;
        }
        
        if (isset($filtros['min_length_nombre']) && 
            strlen($usuario['nombre']) < $filtros['min_length_nombre']) {
            $cumple = false;
        }
        
        return $cumple;
    });
}

// NIVEL 5: Filtrado con transformación (map + filter)
function filtrarYTransformar($array, $condicion, $transformacion) {
    $filtrado = array_filter($array, $condicion);
    return array_map($transformacion, $filtrado);
}

// ==================== FUNCIONES PARA ACTUALIZAR ARRAYS EN ARCHIVOS ====================

/**
 * Actualizar valor en array asociativo dentro de CSV
 */
function actualizarEnCSV($archivo, $claveBusqueda, $valorBusqueda, $campoActualizar, $nuevoValor, $delimitador = ",") {
    if (!file_exists($archivo)) {
        return false;
    }
    
    $datos = cargarDatosSUPER($archivo, 'auto', $delimitador);
    $encontrado = false;
    
    foreach ($datos as &$fila) {
        if (isset($fila[$claveBusqueda]) && $fila[$claveBusqueda] == $valorBusqueda) {
            $fila[$campoActualizar] = $nuevoValor;
            $encontrado = true;
            break;
        }
    }
    
    if (!$encontrado) {
        return false;
    }
    
    // Guardar los datos actualizados
    return guardarArrayCompletoCSV($archivo, $datos, $delimitador);
}

/**
 * Guardar array completo en CSV (sobrescribe el archivo)
 */
function guardarArrayCompletoCSV($archivo, $arrayAsociativo, $delimitador = ",") {
    if (empty($arrayAsociativo)) {
        return false;
    }
    
    $handle = fopen($archivo, 'w');
    if (!$handle) {
        return false;
    }
    
    // Escribir encabezados
    fputcsv($handle, array_keys($arrayAsociativo[0]), $delimitador);
    
    // Escribir datos
    foreach ($arrayAsociativo as $fila) {
        fputcsv($handle, $fila, $delimitador);
    }
    
    fclose($handle);
    return true;
}

/**
 * Incrementar contador en CSV
 */
function incrementarContadorCSV($archivo, $claveBusqueda, $valorBusqueda, $campoContador, $delimitador = ",") {
    $datos = cargarDatosSUPER($archivo, 'auto', $delimitador);
    
    foreach ($datos as &$fila) {
        if (isset($fila[$claveBusqueda]) && $fila[$claveBusqueda] == $valorBusqueda) {
            // Si el campo existe, incrementar, sino inicializar en 1
            $fila[$campoContador] = isset($fila[$campoContador]) ? 
                                   (int)$fila[$campoContador] + 1 : 1;
            return guardarArrayCompletoCSV($archivo, $datos, $delimitador);
        }
    }
    
    return false;
}

/**
 * Actualizar valor en array asociativo dentro de TXT
 */
function actualizarEnTXT($archivo, $claveBusqueda, $valorBusqueda, $campoActualizar, $nuevoValor, $delimitador = '|') {
    if (!file_exists($archivo)) {
        return false;
    }
    
    $lineas = file($archivo, FILE_IGNORE_NEW_LINES);
    $encontrado = false;
    
    foreach ($lineas as &$linea) {
        $partes = explode($delimitador, $linea);
        
        // Buscar el formato clave=valor en cada parte
        foreach ($partes as &$parte) {
            list($clave, $valor) = explode('=', $parte) + [null, null];
            
            if ($clave === $claveBusqueda && $valor == $valorBusqueda) {
                // Encontramos la fila, ahora actualizar el campo específico
                foreach ($partes as &$p) {
                    list($c, $v) = explode('=', $p) + [null, null];
                    if ($c === $campoActualizar) {
                        $p = $c . '=' . $nuevoValor;
                        $encontrado = true;
                        break;
                    }
                }
                $linea = implode($delimitador, $partes);
                break 2;
            }
        }
    }
    
    if ($encontrado) {
        file_put_contents($archivo, implode("\n", $lineas));
        return true;
    }
    
    return false;
}

/**
 * Incrementar contador en TXT
 */
function incrementarContadorTXT($archivo, $claveBusqueda, $valorBusqueda, $campoContador, $delimitador = '|') {
    $lineas = file($archivo, FILE_IGNORE_NEW_LINES);
    $encontrado = false;
    
    foreach ($lineas as &$linea) {
        $partes = explode($delimitador, $linea);
        
        foreach ($partes as &$parte) {
            list($clave, $valor) = explode('=', $parte) + [null, null];
            
            if ($clave === $claveBusqueda && $valor == $valorBusqueda) {
                // Buscar y actualizar el contador
                foreach ($partes as &$p) {
                    list($c, $v) = explode('=', $p) + [null, null];
                    if ($c === $campoContador) {
                        $nuevoValor = isset($v) ? (int)$v + 1 : 1;
                        $p = $c . '=' . $nuevoValor;
                        $encontrado = true;
                        break;
                    }
                }
                $linea = implode($delimitador, $partes);
                break 2;
            }
        }
    }
    
    if ($encontrado) {
        file_put_contents($archivo, implode("\n", $lineas));
        return true;
    }
    
    return false;
}

/**
 * Función universal para contador de visitas (detecta formato automáticamente)
 */
function registrarVisita($archivo, $identificador, $campoContador = 'visitas', $delimitador = null) {
    $extension = pathinfo($archivo, PATHINFO_EXTENSION);
    
    if ($delimitador === null) {
        $delimitador = ($extension === 'csv') ? ',' : '|';
    }
    
    if ($extension === 'csv') {
        return incrementarContadorCSV($archivo, 'email', $identificador, $campoContador, $delimitador);
    } elseif ($extension === 'txt') {
        return incrementarContadorTXT($archivo, 'email', $identificador, $campoContador, $delimitador);
    }
    
    return false;
}

// ==================== FUNCIONES AUXILIARES ESPECÍFICAS PARA CONTADORES ====================

/**
 * Obtener estadísticas de visitas desde CSV
 */
function obtenerEstadisticasVisitasCSV($archivo, $delimitador = ",") {
    $datos = cargarDatosSUPER($archivo, 'auto', $delimitador);
    $estadisticas = [
        'total_visitas' => 0,
        'usuario_mas_activo' => '',
        'max_visitas' => 0
    ];
    
    foreach ($datos as $usuario) {
        if (isset($usuario['visitas'])) {
            $visitas = (int)$usuario['visitas'];
            $estadisticas['total_visitas'] += $visitas;
            
            if ($visitas > $estadisticas['max_visitas']) {
                $estadisticas['max_visitas'] = $visitas;
                $estadisticas['usuario_mas_activo'] = $usuario['nombre'] ?? $usuario['email'];
            }
        }
    }
    
    return $estadisticas;
}

/**
 * Reiniciar contador de visitas
 */
function reiniciarContador($archivo, $identificador, $campoContador = 'visitas', $delimitador = null) {
    $extension = pathinfo($archivo, PATHINFO_EXTENSION);
    
    if ($delimitador === null) {
        $delimitador = ($extension === 'csv') ? ',' : '|';
    }
    
    if ($extension === 'csv') {
        return actualizarEnCSV($archivo, 'email', $identificador, $campoContador, '0', $delimitador);
    } elseif ($extension === 'txt') {
        return actualizarEnTXT($archivo, 'email', $identificador, $campoContador, '0', $delimitador);
    }
    
    return false;
}

// ==================== EJEMPLOS COMPLETOS DE USO ====================

// EJEMPLO 1: ARRAYS INDEXADOS BÁSICOS
/*
$frutas = ['manzana', 'banana', 'naranja'];
eliminarDelArray($frutas, 'banana'); // Elimina 'banana'
guardarArrayIndexadoTXT('frutas.txt', $frutas, "|");
guardarArrayIndexadoCSV('frutas.csv', $frutas, ";");
*/

// EJEMPLO 2: ARRAYS ASOCIATIVOS
/*
$usuario = ['nombre' => 'Juan', 'email' => 'juan@email.com', 'edad' => 25];
eliminarClaveArray($usuario, 'edad'); // Elimina clave 'edad'
borrarValorArray($usuario, 'juan@email.com'); // Elimina por valor
guardarArrayAsociativoTXT('usuario.txt', $usuario, " -> ");
guardarArrayAsociativoCSV('usuarios.csv', $usuario, ";");
*/

// EJEMPLO 3: ARCHIVOS - ELIMINACIÓN
/*
eliminarLineaArchivo('notas.txt', 'texto a borrar');
eliminarFilaCSV('datos.csv', 'valor a eliminar', ";");
*/

// EJEMPLO 4: VERIFICACIÓN DE EXISTENCIA
/*
if (valorExiste('usuarios.csv', 'juan@email.com', ";")) {
    echo "El valor ya existe";
}
*/

// EJEMPLO 5: MOSTRAR DATOS
/*
echo arrayALista($frutas, 'Frutas');
echo arrayALista($usuario, 'Usuario');
echo arrayATabla($frutas, 'Frutas Tabla');
echo arrayATabla($usuario, 'Usuario Tabla');
echo csvATabla('datos.csv', 'Datos CSV', ',');
echo txtALista('notas.txt', 'Notas');
*/

// EJEMPLO 6: SUBIR ARCHIVOS
/*
$resultado = subirArchivoComprobandoDir($_FILES['imagen'], 'uploads');
echo $resultado;
*/

// EJEMPLO 7: VALORES ALEATORIOS
/*
$frutas = ['manzana', 'banana', 'naranja', 'uva'];
echo valorAleatorio($frutas); // Ej: "banana"

$colores = ['rojo' => '#FF0000', 'verde' => '#00FF00', 'azul' => '#0000FF'];
echo valorAleatorioAsociativo($colores); // Ej: "#00FF00"

$numeros = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10];
print_r(valoresAleatorios($numeros, 3)); // Ej: [3, 7, 9]
*/

// EJEMPLO 8: ARRAY_FILTER CON USUARIOS
/*
$usuarios = [
    ['id' => 1, 'nombre' => 'Ana', 'email' => 'ana@test.com', 'rol' => 'admin', 'activo' => true],
    ['id' => 2, 'nombre' => 'Luis', 'email' => 'luis@empresa.com', 'rol' => 'user', 'activo' => true],
    ['id' => 3, 'nombre' => 'Marta', 'email' => 'marta@test.com', 'rol' => 'user', 'activo' => false],
    ['id' => 4, 'nombre' => 'Carlos', 'email' => 'carlos@empresa.com', 'rol' => 'admin', 'activo' => true]
];

// Filtrar por rol
$admins = filtrarUsuariosPorRol($usuarios, 'admin');

// Filtrar con múltiples condiciones
$filtros = [
    'rol' => 'user',
    'email_contiene' => 'empresa',
    'min_length_nombre' => 4
];
$usuariosFiltrados = filtrarUsuariosAvanzado($usuarios, $filtros);

// Filtrar y transformar
$emailsActivos = filtrarYTransformar(
    $usuarios,
    function($usuario) { return $usuario['activo']; },
    function($usuario) { return $usuario['email']; }
);
*/

// EJEMPLO 9: ACTUALIZACIÓN EN ARCHIVOS CSV
/*
// Contador de visitas
registrarVisita('usuarios_visitas.csv', 'admin@test.com', 'visitas');

// Actualizar campo específico
actualizarEnCSV(
    'usuarios.csv',           // archivo
    'email',                  // campo para buscar
    'admin@test.com',         // valor a buscar
    'nombre',                 // campo a actualizar
    'Juan Pérez Actualizado'  // nuevo valor
);
*/

// EJEMPLO 10: ACTUALIZACIÓN EN ARCHIVOS TXT
/*
registrarVisita('contadores.txt', 'admin@test.com', 'visitas');

actualizarEnTXT(
    'configuraciones.txt',
    'usuario_id',
    '123',
    'tema',
    'oscuro',
    '|'
);
*/

// EJEMPLO 11: SISTEMA DE LOGIN CON REGISTRO
/*
session_start();
function procesarLogin($email, $password) {
    // ... validación del login ...
    
    if ($login_exitoso) {
        // Registrar la visita
        registrarVisita('usuarios.csv', $email, 'visitas');
        
        // Actualizar última conexión
        actualizarEnCSV(
            'usuarios.csv',
            'email',
            $email,
            'ultima_conexion',
            date('Y-m-d H:i:s')
        );
        return true;
    }
    return false;
}
*/

// EJEMPLO 12: ESTADÍSTICAS
/*
$estadisticas = obtenerEstadisticasVisitasCSV('usuarios.csv');
echo "Total visitas: " . $estadisticas['total_visitas'];
echo "Usuario más activo: " . $estadisticas['usuario_mas_activo'];
*/

// EJEMPLO 13: REINICIAR CONTADOR
/*
reiniciarContador('usuarios.csv', 'admin@test.com', 'visitas');
*/

// EJEMPLO 14: CARGAR DATOS
/*
$datosCSV = cargarDatosSUPER('archivo.csv', 'auto', ';');
$datosTXT = cargarArchivoUniversal('archivo.txt', '|', false);
*/

// EJEMPLO 15: VALIDACIONES
/*
if (validarEmail('usuario@email.com')) {
    echo "Email válido";
}

if (validarNumero(25, 0, 100)) {
    echo "Número válido";
}
*/

// EJEMPLO 16: ELIMINACIONES MÚLTIPLES
/*
$arrayEjemplo = ['a' => 1, 'b' => 2, 'c' => 1, 'd' => 3];
$eliminados = borrarTodasOcurrenciasValor($arrayEjemplo, 1);
echo "Se eliminaron $eliminados ocurrencias";
*/

// EJEMPLO 17: SISTEMA DE USUARIOS COMPLETO
/*
$usuarios = cargarDatosSUPER('usuarios.csv', 'auto', ';');
$usuariosActivos = filtrarUsuariosPorRol($usuarios, 'activo');
$usuariosOrdenados = ordenarArrayPorClave($usuariosActivos, 'nombre');
crearBackupTimestamp($usuariosOrdenados, 'backups', 'usuarios_activos');
echo arrayATabla($usuariosOrdenados, 'Usuarios Activos Ordenados');
*/

// EJEMPLO 18: SISTEMA DE INVENTARIO
/*
$productos = [
    ['id' => 1, 'nombre' => 'Laptop', 'precio' => 999.99, 'stock' => 5],
    ['id' => 2, 'nombre' => 'Mouse', 'precio' => 25.50, 'stock' => 20],
    ['id' => 3, 'nombre' => 'Teclado', 'precio' => 75.00, 'stock' => 0]
];

// Filtrar productos con stock
$conStock = array_filter($productos, function($producto) {
    return $producto['stock'] > 0;
});
*/

// EJEMPLO 19: SESIONES Y COOKIES
/*
guardarEnSesion('carrito', $productos);
$carrito = obtenerDeSesion('carrito', []);

guardarEnCookie('preferencias', ['tema' => 'oscuro', 'idioma' => 'es'], 86400);
$preferencias = obtenerDeCookie('preferencias', []);
*/

// EJEMPLO 20: SEGURIDAD
/*
$datosUsuario = sanitizarArray($_POST);
$esquema = ['nombre' => 'string', 'edad' => 'int', 'email' => 'email'];
$datosValidados = validarEsquemaArray($datosUsuario, $esquema);
*/

// EJEMPLO 21: BACKUP Y LOGGING
/*
crearBackupArray($usuarios, 'backup_usuarios.json');
registrarLog('Usuario admin inició sesión', 'sistema.log', 'INFO');
logOperacionArray('filtrado', $usuariosFiltrados);
*/

// EJEMPLO 22: DEBUG
/*
debugArray($usuarios, 'Array de Usuarios');
volcarArrayCLI($frutas, 'Array de Frutas');
*/

// EJEMPLO 23: BUSQUEDA Y ORDENACIÓN
/*
$usuarioEncontrado = buscarEnArrayMultidimensional($usuarios, 'email', 'ana@test.com');
$usuariosOrdenados = ordenarArrayPorClave($usuarios, 'nombre', 'desc');
*/

// EJEMPLO 24: CONTEO Y VALORES ÚNICOS
/*
$numeros = [1, 2, 2, 3, 3, 3, 4];
$conteo = contarOcurrencias($numeros); // [1=>1, 2=>2, 3=>3, 4=>1]
$unicos = valoresUnicos($numeros); // [1, 2, 3, 4]
*/

// EJEMPLO 25: COMBINACIÓN Y DIFERENCIAS
/*
$array1 = [1, 2, 3];
$array2 = [3, 4, 5];
$combinados = combinarArrays($array1, $array2); // [1, 2, 3, 3, 4, 5]
$diferencias = diferenciasArrays($array1, $array2); // [1, 2]
*/

// EJEMPLO 26: MANEJO DE STRINGS
/*
$arrayDesdeString = stringAArray("manzana,banana;naranja|uva", [',', ';', '|']);
$stringDesdeArray = arrayAString($frutas, ' - ', '"');
$arrayLimpio = limpiarArrayStrings(['  texto  ', '<script>alert()</script>']);
*/

// EJEMPLO 27: SISTEMA DE RESERVAS (VIAJES)
/*
// En tu página principal de viajes
session_start();

// Añadir reserva
if (isset($_POST['añadir_reserva'])) {
    $idViaje = $_POST['añadir_reserva'];
    if (!in_array($idViaje, $_SESSION['reservas'])) {
        $_SESSION['reservas'][] = $idViaje;
        registrarLog("Reserva añadida: $idViaje", 'reservas.log');
    }
}

// Eliminar reserva
if (isset($_POST['eliminar_reserva'])) {
    $idViaje = $_POST['eliminar_reserva'];
    if (($key = array_search($idViaje, $_SESSION['reservas'])) !== false) {
        unset($_SESSION['reservas'][$key]);
        registrarLog("Reserva eliminada: $idViaje", 'reservas.log');
    }
}
*/

// EJEMPLO 28: PROCESAMIENTO POR LOTES
/*
// Procesar múltiples archivos
$archivos = ['datos1.csv', 'datos2.csv', 'datos3.csv'];
$todosLosDatos = [];

foreach ($archivos as $archivo) {
    if (file_exists($archivo)) {
        $datos = cargarDatosSUPER($archivo, 'auto', ',');
        $todosLosDatos = combinarArrays($todosLosDatos, $datos);
    }
}

// Filtrar y guardar resultado
$datosFiltrados = filtrarUsuariosAvanzado($todosLosDatos, ['activo' => true]);
guardarArrayCompletoCSV('usuarios_activos.csv', $datosFiltrados);
*/

// EJEMPLO 29: MIGRACIÓN ENTRE FORMATOS
/*
// Migrar de TXT a CSV
$datosTXT = cargarArchivoUniversal('datos.txt', '|', false);
guardarArrayCompletoCSV('datos_migrados.csv', $datosTXT);

// Migrar de CSV a TXT
$datosCSV = cargarDatosSUPER('datos.csv', 'auto', ',');
guardarArrayAsociativoTXT('datos_backup.txt', $datosCSV[0], " = ");
*/
?>




