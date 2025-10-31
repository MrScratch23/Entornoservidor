<?php

$productos = [];
$mensaje = "";
$errores = "";

if (isset($_COOKIE['productos'])) {

    $productos = unserialize(($_COOKIE['productos']));
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['enviar'])) {
    $nombreProducto = isset($_POST['producto']) ? htmlspecialchars($_POST['producto']) : '';

    if (!empty($nombreProducto)) {
        $productos[] = $nombreProducto;

        setcookie("productos", serialize($productos), time() + (7 * 24 * 60 * 60), "/");
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    } else {
        $errores = "Por favor, introduce un nombre.";
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['eliminar'])) {
    setcookie("productos", "", time()-3600, "/");
    header("Location: " . $_SERVER['PHP_SELF']);
        exit();
}

    if (empty($errores)) {
        $mensaje .= "<ul>";
        foreach ($productos as $producto) {
            $mensaje .= "<li>" . htmlspecialchars($producto) . "</li>";
        }
        $mensaje .= "</ul>";
    }

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Carrito de Compras con Arrays (PHP + Cookies)</title>
</head>
<link rel="stylesheet" href="https://cdn.simplecss.org/simple.min.css">

<body>

    <h1>Carrito de Compras</h1>

    <h2>Añadir producto</h2>
    <form action="" method="post">
        <label for="producto">Nombre del producto:</label><br>
        <input type="text" name="producto" id="producto"><br><br>

        <input type="submit" name="enviar" value="Agregar al carrito">
        <input type="submit" name="eliminar" value="Borrar carrito">
    </form>

    <h2>Productos en el carrito</h2>
    <div id="lista-carrito">
        <?php
        echo $mensaje;
        ?>

    </div>




</body>

</html>