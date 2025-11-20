<?php

require_once "funcionesBDD.php";



$host = "localhost";
$user = "usuario_tienda";
$password = "1234";
$base = "tienda";

// inicializar variables
$nombre = "";
$descripcion = "";
$precio = "";
$errores = [];
$mensaje = "";
$conexion = null;

// procesar formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['añadir'])) {
    $conexion = conectarBDD($host, $user, $password, $base);
    
    // para añadir
    if (isset($_POST['añadir'])) {
        $nombre = trim($_POST['nombre'] ?? '');
        $descripcion = trim($_POST['descripcion'] ?? '');
        $precio = trim($_POST['precio'] ?? '');

        // validaciones
        if (empty($nombre)) {
            $errores['nombre'] = "El nombre no puede estar vacío";
        }

        if (!is_numeric($precio) || $precio === '') {
            $errores['precio'] = "Debe ser un número válido";
        }

        $precio_numero = floatval($precio);

        if (empty($errores)) {
            // forma segura con stmt
            $stmt = $conexion->prepare("INSERT INTO productos (nombre, descripcion, precio) values (?,?,?)");
            $stmt->bind_param("ssd", $nombre, $descripcion, $precio_numero);
            $stmt->execute(); 

            if ($stmt->affected_rows > 0) {
                $mensaje = "Producto agregado de forma exitosa";
                // limpiar campos después de éxito
                $nombre = "";
                $descripcion = "";
                $precio = "";
                
            } else {
                $mensaje = "Error al insertar el producto";
            }
            $stmt->close();
        } else {
            $mensaje = "Ocurrió un error en la validación.";
        }
    }
    
 
    
    // cerrar la conexion
    if ($conexion) {
        desconectarBDD($conexion);
    }
}





?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tienda</title>
    <link rel="stylesheet" href="https://cdn.simplecss.org/simple.min.css">
</head>
<body>
    
    <form action="tienda.php" method="post">
        <label for="nombre">Nombre del producto:</label>
        <input type="text" id="nombre" name="nombre">
        <?php if (isset($errores['nombre'])): ?>
            <br><span style="color: red;"><?php echo $errores['nombre']; ?></span>
        <?php endif; ?>
        
        <label for="descripcion">Descripción del producto:</label>
        <input type="text" id="descripcion" name="descripcion">
        
        <label for="precio">Precio del producto:</label>
        <input type="text" id="precio" name="precio">
        <?php if (isset($errores['precio'])): ?>
            <br><span style="color: red;"><?php echo $errores['precio']; ?></span>
        <?php endif; ?>
        <br>
        <button type="submit" name="añadir">Añadir Producto</button>
        <br>
        <a href="mostrar_tabla.php" style="display: inline-block; background: #28a745; color: white; padding: 10px 15px; text-decoration: none; border-radius: 5px; text-align: center;">
        Mostrar Productos
        </a>

        <div class="notice">
            <?php
            if (!empty($mensaje)) {
                echo $mensaje;
            }
            ?>
        </div>
    </form>


    <!-- Botón para mostrar productos como enlace -->




</body>
</html>