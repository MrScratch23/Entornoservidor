<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Formulario sin sanitizar</title>
</head>
<body>
    <form method="POST" action="<?=$_SERVER['PHP_SELF']?>">
        <label for="nombre">Nombre:</label>
        <input type="text" name="nombre" id="nombre" value="">
        <button type="submit">Enviar</button>
        <!-- <input type="submit" name="enviar" value="Enviar2"> -->
    </form>
    <?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Sin sanitizar: vulnerable a XSS
        echo "<p>Hola, " . $_POST['nombre'] . "!</p>";
    }
    ?>
</body>
</html>