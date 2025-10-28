<?php

$mensaje = "";
$errores = array(
    "nombre" => "",
    "fichero" => "",
);

$nombre = isset($_POST['nombre']) ? htmlspecialchars($_POST['nombre']) : '';




$manejador = fopen("usuarios.csv", "r");
$nombreArray = [];

while (($fila = fgetcsv($manejador)) !== false) {

if ($fila[1] !== "nombre") {
    $errores ['nombre'] = "El nombre no existe en el archivo.";
} else {

    $usuarios[] = [
        'id'   => $fila[0],
        'nombre' => $fila[1],
        'apellido'    => $fila[2],
        'email' => $fila[3]
    ];
}
}
fclose($manejador);

// enseñamos todos los usuarios
foreach ($usuarios as $us) {
    if ($us['nombre'] === $nombre) {   
        $mensaje .= "ID: " . $us['id'] . " - Nombre: " . $us['nombre'] . " - Apellido: " . $us['apellido'] . " - Email: " . $us['email'] . "<br>";
    }
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<link rel="stylesheet" href="https://cdn.simplecss.org/simple.min.css">
<body>

    <form action="" method="post">

<!-- placeholder con texto y un bonton de buscar -->
  <label for="nombre">Nombre</label>
            <input type="text" id="nombre" name="nombre" value="<?php echo $nombre; ?>">
            <small class="error <?php echo empty($errores['nombre']) ? 'hidden' : ''; ?>">
                <?php echo $errores['nombre']; ?>
            </small>
    <button>Buscar</button>

    </form>




    <!-- php donde de sus datos -->
<?php
    if (empty($errores)) {
        echo $mensaje;
    }
?>


    
</body>
</html>