<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <?php
    // Recibir y mostrar las variables pasadas por URL
    $nombre = $_GET['nombre'];
    $apellidos = $_GET['apellidos'];

    echo "Hola, " . $nombre . " " . $apellidos . ".";
    ?>

</body>

</html>