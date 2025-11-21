<?php
require_once "funcionesBDD.php";
$conexion = conectarBDD();

// a ver que leches me esta llegando
echo "<pre>";
echo "Contenido de \$_GET:\n";
print_r($_GET);
echo "ID recibido: '" . ($_GET['id_producto'] ?? 'NO RECIBIDO') . "'\n";
echo "Tipo: " . gettype($_GET['id_producto'] ?? 'null') . "\n";
echo "</pre>";

$idproducto = $_GET['id_producto'] ?? ''; 
$idproducto = intval($idproducto);
$mensajeError = "";
$mensajeExito = "";
$producto = [];
$errores = [];

// consulta para obtener el producto
$stmt = $conexion->prepare("SELECT * FROM productos WHERE id_producto=?");
$stmt->bind_param("i", $idproducto);
$stmt->execute();
$resultado = $stmt->get_result();

if ($resultado->num_rows > 0) {
    while ($fila = $resultado->fetch_assoc()) {
        $producto =[
            "idproducto" => $fila['id_producto'],
            "nombre" => $fila['nombre'],
            "descripcion" => $fila['descripcion'],
            "precio" => $fila ['precio']
        ];
    }
} else {
    $mensajeError = "<p class='notice'>No se encontraron productos</p>";
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'] ?? '';
    $descripcion = $_POST['descripcion'] ?? NULL;
    $precio = $_POST['precio'] ?? '';
    $id_producto = $_POST['id'] ?? ''; 
    // Validaciones
    if ($nombre === '') {
        $errores['nombre'] = "El nombre no puede estar vacio.";
    }
    
    if ($precio === '') {
        $errores['precio'] = "El precio no puede estar vacio.";
    }

    if (!is_numeric($precio)) {
        $errores['precio'] = "Introduzca un numero valido.";
    }

    $precio_numero = floatval($precio); 

    if (empty($errores)) {
        // forma segura con stmt
        $stmt = $conexion->prepare("UPDATE productos 
                       SET nombre = ?, descripcion = ?, precio = ? 
                       WHERE id_producto = ?");
        $stmt->bind_param("ssdi", $nombre, $descripcion, $precio_numero, $id_producto);
        
        if ($stmt->execute()) {
            if ($stmt->affected_rows > 0) {
                $mensajeExito = "<p class='success'>Producto actualizado correctamente</p>";
                
                // actualizar los datos del producto en el array para mostrarlos en el formulario
                $producto['nombre'] = $nombre;
                $producto['descripcion'] = $descripcion;
                $producto['precio'] = $precio_numero;
            } else {
                $mensajeError = "<p class='notice'>No se realizaron cambios en el producto</p>";
            }
        } else {
            $mensajeError = "<p class='error'>Error al actualizar el producto: " . $conexion->error . "</p>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modificar Producto</title>
</head>
<link rel="stylesheet" href="https://cdn.simplecss.org/simple.min.css">
<body>
    <h1>Modificar Producto</h1>
    
    <!-- Mostrar mensajes de éxito y error -->
    <?php if (!empty($mensajeExito)): ?>
        <div style="color: green; padding: 10px; border: 1px solid green; margin-bottom: 15px;">
            <?php echo $mensajeExito; ?>
        </div>
    <?php endif; ?>
    
    <?php if (!empty($mensajeError)): ?>
        <div style="color: red; padding: 10px; border: 1px solid red; margin-bottom: 15px;">
            <?php echo $mensajeError; ?>
        </div>
    <?php endif; ?>

    <?php if (!empty($producto)): ?>
    <form action="modificar.php?id_producto=<?php echo $idproducto; ?>" method="post">
        <!-- Mostrar ID (solo lectura) -->
        <label for="id">ID del producto:</label>
        <input type="text" id="id" name="id" value="<?php echo htmlspecialchars($producto['idproducto']); ?>" readonly style="background-color: #f0f0f0;">
        
        <!-- Campo Nombre -->
        <label for="nombre">Nombre del producto:</label>
        <input type="text" id="nombre" name="nombre" value="<?php echo htmlspecialchars($producto['nombre']); ?>">
        <?php if (isset($errores['nombre'])): ?>
            <div style="color: red; font-size: 0.9em;"><?php echo $errores['nombre']; ?></div>
        <?php endif; ?>
        
        <!-- Campo Descripción -->
        <label for="descripcion">Descripción del producto:</label>
        <textarea id="descripcion" name="descripcion" rows="4"><?php echo htmlspecialchars($producto['descripcion'] ?? ''); ?></textarea>
        
        <!-- Campo Precio -->
        <label for="precio">Precio del producto:</label>
        <input type="text" id="precio" name="precio" value="<?php echo htmlspecialchars($producto['precio']); ?>">
        <?php if (isset($errores['precio'])): ?>
            <div style="color: red; font-size: 0.9em;"><?php echo $errores['precio']; ?></div>
        <?php endif; ?>
        
        <!-- Botones -->
        <div style="margin-top: 20px;">
            <button type="submit" style="background-color: #007bff; color: white; padding: 10px 20px; border: none; border-radius: 4px;">Actualizar Producto</button>
            <a href="mostrar_tabla.php" style="margin-left: 10px;">Cancelar</a>
        </div>
    </form>
    <?php else: ?>
        <p>No se puede mostrar el formulario sin datos del producto.</p>
    <?php endif; ?>
</body>
</html>