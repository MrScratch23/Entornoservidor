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

function cargarDatos($archivo)
{
    //array que devolveremos con los datos de todos los usuarios.
    $usuarios = [];
    $temp = []; // array temporal
    if (!file_exists($archivo)) return $usuarios; //salimos si no encuentra el archivo.
    $manejador = @fopen($archivo, "r");
    if ($manejador) { //si no da error al abrirlo
        while (!feof($manejador)) {
            $temp = fgetcsv($manejador);
            if ($temp == false || count($temp) < 3) continue; //si no hay datos o son menos de 3 campos
            else $usuarios[$temp[0]] = ["password" => $temp[1], "contador" => intval($temp[2])];
        }

        fclose($manejador);
    }
    return $usuarios;
}


function cargarDatosGenerica($archivo)
{
    //array que devolveremos con los datos de todos los usuarios.
    $usuarios = [];
    $temp = []; // array temporal
    if (!file_exists($archivo)) return $usuarios; //salimos si no encuentra el archivo.
    $manejador = @fopen($archivo, "r");
    if ($manejador) { //si no da error al abrirlo
        while (!feof($manejador)) {
            $temp = fgetcsv($manejador);
            if ($temp == false || count($temp) < 3) continue; //si no hay datos o son menos de 3 campos
            else $usuarios[$temp[0]] = ["password" => $temp[1], "contador" => intval($temp[2])];
        }

        fclose($manejador);
    }
    return $usuarios;
}


function cargarDatosSUPER($archivo, $formato = 'indexado')
{
    $datos = [];
    if (!file_exists($archivo)) return $datos;
    
    $manejador = @fopen($archivo, "r");
    if ($manejador) {
        // Leer primera línea para detectar encabezados
        $primeraLinea = fgetcsv($manejador);
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
                $temp = fgetcsv($manejador);
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
                $temp = fgetcsv($manejador);
                if ($temp === false || (count($temp) === 1 && empty(trim($temp[0])))) continue;
                $datos[] = $temp;
            }
        }
        
        fclose($manejador);
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
?>
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

/*Array indexado
$frutas = ['manzana', 'banana', 'naranja', 'uva'];
echo valorAleatorio($frutas); // Ej: "banana"

Array asociativo  
$colores = ['rojo' => '#FF0000', 'verde' => '#00FF00', 'azul' => '#0000FF'];
echo valorAleatorioAsociativo($colores); // Ej: "#00FF00"

 Múltiples valores
$numeros = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10];
print_r(valoresAleatorios($numeros, 3)); // Ej: [3, 7, 9]
/*
?>