<?php
   // para mostrar
   require_once "funcionesBDD.php";
   $mensajeTabla = "";

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
        // Generar encabezados desde las keys del primer elemento + columnas de acciones
        $html .= '<tr>';
        foreach (array_keys($array[0]) as $header) {
            $html .= "<th style='padding: 8px; background: #f0f0f0;'>" . htmlspecialchars($header) . "</th>";
        }
        // Añadir columna para acciones
        $html .= "<th style='padding: 8px; background: #f0f0f0;'>Acciones</th>";
        $html .= '</tr>';
        
        // Generar filas
        foreach ($array as $fila) {
            $html .= '<tr>';
            foreach ($fila as $valor) {
                $html .= "<td style='padding: 8px;'>" . htmlspecialchars($valor) . "</td>";
            }
            // Añadir botones de acciones
            $html .= "<td style='padding: 8px; text-align: center;'>";
           
            // form para el boton modificar
            $html .= "<form action='modificar.php' method='post' style='display: inline; margin-right: 5px;'>";
            $html .= "<input type='hidden' name='id_producto' value='" . htmlspecialchars($fila['id_producto']) . "'>";
            $html .= "<input type='hidden' name='nombre' value='" . htmlspecialchars($fila['nombre']) . "'>";
            $html .= "<input type='hidden' name='descripcion' value='" . htmlspecialchars($fila['descripcion']) . "'>";
            $html .= "<input type='hidden' name='precio' value='" . htmlspecialchars($fila['precio']) . "'>";
            $html .= "<button type='submit' style='background: #28a745; color: white; border: none; padding: 5px 10px; border-radius: 3px; cursor: pointer;'>Modificar</button>";
            $html .= "</form>";
            
            // para el boton eliminar
            $html .= "<form action='eliminar.php' method='post' style='display: inline;'>";
            $html .= "<input type='hidden' name='id_producto' value='" . htmlspecialchars($fila['id_producto']) . "'>";
            $html .= "<input type='hidden' name='nombre' value='" . htmlspecialchars($fila['nombre']) . "'>";
            $html .= "<button type='submit' style='background: #dc3545; color: white; border: none; padding: 5px 10px; border-radius: 3px; cursor: pointer;' onclick='return confirm(\"¿Estás seguro de que quieres eliminar " . htmlspecialchars($fila['nombre']) . "?\")'>Eliminar</button>";
            $html .= "</form>";
            
            $html .= "</td>";
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



$host = "localhost";
$user = "usuario_tienda";
$password = "1234";
$base = "tienda";



$conexion = conectarBDD($host, $user, $password, $base);
$resultado = $conexion->query("SELECT * FROM productos");
        
        if ($resultado->num_rows > 0) {
            $productos = [];
            while ($fila = $resultado->fetch_assoc()) {
                $productos[] = $fila;
            }
            $mensajeTabla = arrayATabla($productos, "Lista de Productos");
        } else {
            $mensajeTabla = "<p class=notice>No se encontraron productos</p>";
        }
    
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdn.simplecss.org/simple.min.css">
</head>
<body>


<?php
echo $mensajeTabla;
?>

    <a href="tienda.php">
        Volver atras
        </a>
    
</body>
</html>