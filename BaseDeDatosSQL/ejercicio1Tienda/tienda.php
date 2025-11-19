<?php

require_once "funcionesBDD.php";


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

$host = "localhost";
$user = "usuario_tienda";
$password = "1234";
$base = "tienda";
$nombre = "";
$descripcion = null;
$precio = "";
$errores = [];
$mensaje = "";
$mensajeTabla = "";
// establecer la conexion


// si es opcional, null
// $descripcion = $_POST['descripcion'] ?? null;

/* insertar prueba
$sql = "INSERT INTO productos (id_producto, nombre, descripcion, precio) values (1, 'Lavavajillas', 'Pa lavar platos, mu moderno', 500 )";

if (mysqli_query($conexion, $sql)) {
    echo "Producto insertado correctamente";
} else {
    echo "Error al insertar el producto";
}
*/


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $conexion = conectarBDD($host, $user, $password, $base);

    $nombre = $_POST['nombre'] ?? '';

    if (isset($_POST['descripcion'])) {
        $descripcion = $_POST['descripcion'];
    }

    $precio = $_POST['precio'] ?? '';


   if (isset($_POST['mostrar'])) {
    $resultado = $conexion->query("SELECT * FROM productos");
    
    if ($resultado->num_rows > 0) {
        // Recoger todos los datos en un array
        $productos = [];
        while ($fila = $resultado->fetch_assoc()) {
            $productos[] = $fila;
        }
        $mensajeTabla = arrayATabla($productos, "Lista de Productos");
    } else {
        $mensajeTabla = "No se encontraron productos";
    }
}

if (empty($nombre)) {
    $errores['nombre'] = "El nombre no puede estar vacio";
}

if (!is_numeric($precio)) {
    $errores['precio'] = "Debe ser un numero valido";
}

$precio = intval($precio);

if (empty($precio)) {
   $errores['precio'] = "El precio no puede estar vacio";
}


if (empty($errores)) {
    // para hacerlo de forma segura
    $stmt = $conexion->prepare("INSERT INTO productos (nombre, descripcion, precio) values (?,?,?)");
    $stmt -> bind_param("ssd", $nombre, $descripcion, $precio);
    $stmt -> execute(); 

    if ($stmt->affected_rows > 0) {
        $mensaje = "Producto agregado de forma exitosa";
        // limpiamos los campos para que no se metan mas productos con el mismo nombre
        $nombre = "";
        $descripcion = null;
        $precio = "";
        $mensaje = "";
       
    } else {
        $mensaje = "Error al insertar el producto";
    }

    $stmt->close();

} else {
    $mensaje = "Ocurrio un error.";
}
desconectarBDD($conexion);


}

/// cerrar la conexion con la funcion





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
  

<form action="tienda.php" method="post">
  <label for="nombre">Nombre del producto:</label>
  <input type="text" id="nombre" name="nombre" value<?php echo htmlspecialchars($nombre) ?>>
  <?php if (isset($errores['nombre'])): ?>
      <br><span style="color: red;"><?php echo $errores['nombre']; ?></span>
  <?php endif; ?>
    <label for="nombre">Descripcion del producto:</label>
  <input type="text" id="descripcion" name="descripcion" value<?php echo htmlspecialchars($descripcion) ?>>
  <?php if (isset($errores['descripcion'])): ?>
      <br><span style="color: red;"><?php echo $errores['descripcion']; ?></span>
  <?php endif; ?>
 <label for="nombre">Precio del producto:</label>
  <input type="text" id="precio" name="precio" value<?php echo htmlspecialchars($precio) ?>>
  <?php if (isset($errores['precio'])): ?>
      <br><span style="color: red;"><?php echo $errores['precio']; ?></span>
  <?php endif; ?>
  <label>Añadir el producto:<br>
  <button id="añadir" type="submit">Añadir</button>
  </label>
  <label>Mostrar todos:<br>
  <button id="añadir" type="subtmit" name="mostrar">Mostrar</button>
  </label>

  <div class="notice"><?php
  if (!empty($mensaje)) {
    echo $mensaje;
  }
  if (!empty($mensajeTabla)) {
    echo $mensajeTabla;
  }



  ?></div>

</form>
    
</body>
</html>

