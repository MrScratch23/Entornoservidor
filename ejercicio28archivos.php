<?php

$listaProductos = array();

if (file_exists("/home/DAW2/Entornoservidor/productos.txt")) {
    $miarchivo = fopen("/home/DAW2/Entornoservidor/productos.txt", "r") or die("No se pudo leer el fichero."); 
    // Carga e imprime productos
$listaProductos = cargarProductosDesdeArchivo($miarchivo);
imprimirProductos($listaProductos);
} else {
    echo "El fichero no existe.";
    exit;
}

function cargarProductosDesdeArchivo($archivo) {
    $productos = array();
    while (($linea = fgets($archivo)) !== false) {
        $partes = explode("|", trim($linea));
        if (count($partes) == 4) {
            $producto = array(
                "ID"       => $partes[0],
                "Nombre"   => $partes[1],
                "Precio"   => $partes[2],
                "Cantidad" => $partes[3]
            );
            $productos[] = $producto;
        }
    }
    fclose($archivo);
    return $productos;
}

function arrayAsociativoATablaHTML($array) {
    if (empty($array)) {
        return "<p>No hay datos para mostrar.</p>";
    }

    $html = "<table border='1' cellpadding='5' cellspacing='0' style='border-collapse: collapse;'>";

    // Encabezados
    $html .= "<tr>";
    foreach (array_keys($array[0]) as $clave) {
        $html .= "<th>" . htmlspecialchars($clave) . "</th>";
    }
    $html .= "</tr>";

    // Filas
    foreach ($array as $fila) {
        $html .= "<tr>";
        foreach ($fila as $valor) {
            $html .= "<td>" . htmlspecialchars($valor) . "</td>";
        }
        $html .= "</tr>";
    }

    $html .= "</table>";
    return $html;
}

function imprimirProductos($listaProductos) {
    echo "<h2>Listado de Productos</h2>";
    echo arrayAsociativoATablaHTML($listaProductos);
}




?>
