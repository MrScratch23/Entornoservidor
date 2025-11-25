<?php
   // para mostrar
   require_once "funcionesBDD.php";
   $mensajeTabla = "";

   // Verificar si hay mensaje de éxito
$mensaje = $_GET['mensaje'] ?? '';

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
        $html .= "<form action='modificar.php' method='get' style='display: inline; margin-right: 5px;'>";
        $html .= "<input type='hidden' name='id_producto' value='" . htmlspecialchars($fila['id_producto']) . "'>";
        $html .= "<button type='submit' style='background: #28a745; color: white; border: none; padding: 5px 10px; border-radius: 3px; cursor: pointer;'>Modificar</button>";
        $html .= "</form>";

// para el boton eliminar
        $html .= "<form action='eliminar.php' method='get' style='display: inline;'>";
        $html .= "<input type='hidden' name='id_producto' value='" . htmlspecialchars($fila['id_producto']) . "'>";
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







$conexion = conectarBDD();
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

<?php if ($mensaje): ?>
    <div style="background: #d4edda; color: #155724; padding: 10px; margin: 10px 0; border: 1px solid #c3e6cb; border-radius: 4px;">
        <?php echo htmlspecialchars($mensaje); ?>
    </div>
<?php endif; ?>

<?php
echo $mensajeTabla;
?>

<a href="tienda.php">Insertar producto</a>


</body>
</html>