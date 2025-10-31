<?php

/**
 * Ejercicio realizado por P.Lluyot. 2DAW
 */
//variables
$contenido = "";
$archivo = 'productos.txt';
$arrayTitulos = ["ID", "Nombre", "Precio", "Stock"];

// Función para leer un archivo y cargar los productos en un array bidimensional
//devuelve NULL si no se puede abrir el archivo
function cargarProductosDesdeArchivo($fichero)
{
    $listaProductos = [];  // Inicializa un array vacío para almacenar los productos
    // Abre el archivo en modo de solo lectura ("r")
    // Usar @ para evitar el warning y comprobar si se pudo abrir
    $manejador = @fopen($fichero, "r");
    if ($manejador) {
        // Lee el archivo línea por línea
        while (!feof($manejador)) {
            $linea = fgets($manejador);
            //echo $linea;
            $datosProducto = explode("|", trim($linea));
            $listaProductos[] = $datosProducto;
        }
        fclose($manejador);
    }
    else {
        return null;
    }
    // Retorna el array con todos los productos cargados
    return $listaProductos;
}
// Función para generar una tabla HTML a partir de un array bidimensional
function tablaArrayHTML($arrayBidimensional, $arrayTitulos = null)
{
    $tabla = "";
    //si no es un array
    if (!is_array($arrayBidimensional)) return "";
    //si el array está vacíoº
    if (empty($arrayBidimensional)) return "";
    $tabla = "<table>";
    //TITULOS
    if ($arrayTitulos != null) {
        $tabla .= "<thead><tr>";
        //iteramos por cada elemento del título
        foreach ($arrayTitulos as $titulo) {
            $tabla .= "<th>$titulo</th>";
        }
        $tabla .= "</tr></thead>";
    }
    //CONTENIDO
    $tabla .= "<tbody>";
    foreach ($arrayBidimensional as $arrayFila) {
        $tabla .= "<tr>";
        foreach ($arrayFila as $columna) {
            $tabla .= "<td>$columna</td>";
        }
        $tabla .= "</tr>";
    }
    $tabla .= "</tbody>";
    $tabla .= "</table>";
    return $tabla;
}

// GENERAL
//comprobamos que el fichero existe
if (!file_exists($archivo)) {
    $contenido = "El fichero no existe";
} else {
    //cargamos el array con los productos
    $productos = cargarProductosDesdeArchivo($archivo);
    //si devuelve algún producto, lo mostramos en una tabla HTML
    if (!empty($productos)) {
        $contenido = tablaArrayHTML($productos, $arrayTitulos);
    } elseif ($productos === null) {
        $contenido = "Error al cargar los productos.";
    } else {
        $contenido = "No se encontraron productos en el archivo.";
    }
}

?>
<!DOCTYPE html>
<html lang='es'>

<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>P.Lluyot</title>
    <link rel='stylesheet' href='https://cdn.simplecss.org/simple.min.css'>
</head>

<body>
    <header>
        <h2>Tabla de productos</h2>
    </header>
    <main>
        <!-- código php -->
        <?php
        if (!empty($contenido)) echo $contenido;
        ?>

    </main>
    <footer>
        <p>P.Lluyot</p>
    </footer>
</body>

</html>