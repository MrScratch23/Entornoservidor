<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <?php
    $frutas = array("manzana", "naranja", "plátano");
    $colores = ["rojo", "verde", "azul"];
    $nombres = ['Pepe','Juan','Ana'];
    $combinado = array_merge($frutas, $colores, $nombres);
    echo "<pre>";
    print_r($combinado);  // Muestra el array combinado
    
    var_dump($combinado);
    echo "</pre>";
    
    ?>

</body>

</html>