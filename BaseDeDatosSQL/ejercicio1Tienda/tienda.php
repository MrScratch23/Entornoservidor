<?php

require_once "funcionesBDD.php";

$host = "localhost";
$user = "usuario_tienda";
$password = "1234";
$base = "tienda";

// establecer la conexion
$conexion = conectarBDD($host, $user, $password, $base);

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







/// cerrar la conexion con la funcion

desconectarBDD($conexion);



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

<form action="" method="post">
  <label for="nombre">Nombre del producto:</label>
  <input type="text" id="nombre" name="nombre" value<?php htmlspecialchars($nombre) ?>>
  <?php if (isset($errores['nombre'])): ?>
      <br><span style="color: red;"><?php echo $errores['nombre']; ?></span>
  <?php endif; ?>
    <label for="nombre">Descripcion del producto:</label>
  <input type="text" id="descripcion" name="descripcion">
  <?php if (isset($errores['descripcion'])): ?>
      <br><span style="color: red;"><?php echo $errores['descripcion']; ?></span>
  <?php endif; ?>
 <label for="nombre">Precio del producto:</label>
  <input type="text" id="precio" name="precio">
  <?php if (isset($errores['precio'])): ?>
      <br><span style="color: red;"><?php echo $errores['precio']; ?></span>
  <?php endif; ?>

  <div class="notice"> Mensaje de exito.</div>

</form>
    
</body>
</html>

