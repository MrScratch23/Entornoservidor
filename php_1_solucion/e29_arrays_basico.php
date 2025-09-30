<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP</title>
</head>

<body>
    <?php
    $colores = array("rojo", "verde", "azul");
    $colores[1] = "amarillo";  // Cambia "verde" por "amarillo"
   
    echo "<pre>";
        print_r($colores);  // Muestra el array modificado
    echo "</pre>";
    ?>
</body>

</html>