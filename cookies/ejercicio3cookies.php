<?php
$mensaje = "";
// booleano para controlar si se muestra el formulario o no
$mostrarFormulario = true;

if (isset($_COOKIE['nombreusuario'])) {
    $nombreUsuario = htmlspecialchars($_COOKIE['nombreusuario']);
    $mensaje = "Bienvenido $nombreUsuario";
    $mostrarFormulario = false;
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['enviar'])) {
    $nombre = isset($_POST['nombre']) ? htmlspecialchars($_POST['nombre']) : '';

    if (!empty($nombre)) {
        setcookie("nombreusuario", $nombre, time() + (15 * 60), "/");
        // redirigir para evitar reenvío del formulario y mostrar el mensaje limpio
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    } else {
        $mensaje = "Por favor, introduce un nombre.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Documento</title>
    <link rel="stylesheet" href="https://cdn.simplecss.org/simple.min.css">
</head>

<body>

    <?php if ($mostrarFormulario): ?>
        <form action="" method="post">
            <label for="nombre">Nombre:</label>
            <input type="text" id="nombre" name="nombre">
            <input type="submit" name="enviar" value="Guardar nombre">
        </form>
    <?php endif; ?>

    <?php
    echo "<p class='notice'>$mensaje</p>";
    ?>

</body>

</html>