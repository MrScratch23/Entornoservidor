<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <?php
    $a = 10;         // Asignación inicial
    $b = $a;        // Asignación por copia

    echo "Valor de a: $a<br>"; // Muestra: Valor de a: 10
    echo "Valor de b: $b<br>"; // Muestra: Valor de b: 10
    
    echo "cambiamos el valor de b<br>";

    $b += 5;        // Modificamos $b
    echo "Valor de a: $a<br>"; // Muestra: Valor de a: 10
    echo "Valor de b: $b<br>"; // Muestra: Valor de b: 15
    ?>
</body>

</html>