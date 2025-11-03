<?php
// ==================== FUNCIONES PARA JSON ====================

// Leer JSON y convertir a array
function leerJSON($archivo) {
    if (!file_exists($archivo)) return [];
    
    $contenido = file_get_contents($archivo);
    $datos = json_decode($contenido, true);
    
    return $datos ?? [];
}

// Guardar array en JSON
function guardarJSON($archivo, $array) {
    $json = json_encode($array);
    file_put_contents($archivo, $json);
    return true;
}

// Añadir elemento a JSON (acepta arrays asociativos directamente)
function añadirElementoJSON($archivo, $elemento) {
    $datos = leerJSON($archivo);
    $datos[] = $elemento;
    return guardarJSON($archivo, $datos);
}

// Eliminar elemento de JSON por valor
function eliminarElementoJSON($archivo, $valor) {
    $datos = leerJSON($archivo);
    
    $clave = array_search($valor, $datos, true);
    if ($clave !== false) {
        unset($datos[$clave]);
        $datos = array_values($datos);
    }
    
    return guardarJSON($archivo, $datos);
}

// Verificar si valor existe en JSON
function valorExisteJSON($archivo, $valor) {
    $datos = leerJSON($archivo);
    return in_array($valor, $datos, true);
}

// Obtener datos aleatorios (si no se indica cantidad, devuelve 1)
function obtenerAleatorioJSON($archivo, $cantidad = 1) {
    $datos = leerJSON($archivo);
    
    if (empty($datos)) {
        return "No hay datos disponibles";
    }
    
    if ($cantidad >= count($datos)) {
        return $datos;
    }
    
    $clavesAleatorias = array_rand($datos, $cantidad);
    
    if ($cantidad == 1) {
        return $datos[$clavesAleatorias];
    }
    
    $datosAleatorios = [];
    foreach ($clavesAleatorias as $clave) {
        $datosAleatorios[] = $datos[$clave];
    }
    
    return $datosAleatorios;
}

// Mostrar datos JSON en lista
function jsonALista($archivo, $titulo = '') {
    $datos = leerJSON($archivo);
    
    if (empty($datos)) return "<p>No hay datos</p>";
    
    $html = '';
    if ($titulo) {
        $html .= "<h3>$titulo</h3>";
    }
    
    $html .= '<ul>';
    foreach ($datos as $dato) {
        if (is_array($dato)) {
            $html .= "<li>" . implode(", ", $dato) . "</li>";
        } else {
            $html .= "<li>$dato</li>";
        }
    }
    $html .= '</ul>';
    return $html;
}

// Mostrar datos JSON en tabla
function jsonATabla($archivo, $titulo = '') {
    $datos = leerJSON($archivo);
    
    if (empty($datos)) return "<p>No hay datos</p>";
    
    $html = '';
    if ($titulo) {
        $html .= "<h3>$titulo</h3>";
    }
    
    $html .= '<table border="1">';
    
    if (is_array($datos[0])) {
        $html .= '<tr>';
        foreach (array_keys($datos[0]) as $header) {
            $html .= "<th>$header</th>";
        }
        $html .= '</tr>';
        
        foreach ($datos as $fila) {
            $html .= '<tr>';
            foreach ($fila as $valor) {
                $html .= "<td>$valor</td>";
            }
            $html .= '</tr>';
        }
    } else {
        foreach ($datos as $fila) {
            $html .= '<tr><td>' . $fila . '</td></tr>';
        }
    }
    
    $html .= '</table>';
    return $html;
}

// ==================== EJEMPLOS DE USO ====================

// Ejemplo 1: Crear y guardar datos
$usuarios = [
    ["nombre" => "Ana", "edad" => 25, "ciudad" => "Madrid"],
    ["nombre" => "Luis", "edad" => 30, "ciudad" => "Barcelona"],
    ["nombre" => "Marta", "edad" => 28, "ciudad" => "Valencia"]
];
guardarJSON('usuarios.json', $usuarios);

// Ejemplo 2: Añadir nuevo usuario
$nuevoUsuario = ["nombre" => "Carlos", "edad" => 35, "ciudad" => "Sevilla"];
añadirElementoJSON('usuarios.json', $nuevoUsuario);

// Ejemplo 3: Leer y mostrar
$datosUsuarios = leerJSON('usuarios.json');
echo "Total de usuarios: " . count($datosUsuarios) . "<br>";

// Ejemplo 4: Verificar si existe
if (valorExisteJSON('usuarios.json', "Ana")) {
    echo "Ana existe en los datos<br>";
}

// Ejemplo 5: Obtener aleatorios
$usuarioAleatorio = obtenerAleatorioJSON('usuarios.json');
echo "Usuario aleatorio: ";
print_r($usuarioAleatorio);
echo "<br>";

$tresAleatorios = obtenerAleatorioJSON('usuarios.json', 2);
echo "2 usuarios aleatorios: ";
print_r($tresAleatorios);
echo "<br>";

// Ejemplo 6: Mostrar en lista y tabla
echo jsonALista('usuarios.json', 'Usuarios en lista');
echo jsonATabla('usuarios.json', 'Usuarios en tabla');

// Ejemplo 7: Eliminar un elemento
eliminarElementoJSON('usuarios.json', "Luis");
echo "Después de eliminar a Luis:<br>";
echo jsonATabla('usuarios.json', 'Usuarios actualizados');

?>