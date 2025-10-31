<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <?php
    // Declaración de dos números
    $num1 = 10;
    $num2 = 3;

    // Suma
    echo "La suma de $num1 y $num2 es: " . ($num1 + $num2) . "<br>";

    // Resta
    echo "La resta de $num1 y $num2 es: " . ($num1 - $num2) . "<br>";

    // Multiplicación
    echo "La multiplicación de $num1 y $num2 es: " . ($num1 * $num2) . "<br>";

    // División
    printf("La división de $num1 entre $num2 es: %0.2f <br>", ($num1 / $num2));

    // Módulo (resto de la división)
    echo "El módulo de $num1 y $num2 es: " . ($num1 % $num2) . "<br>";

    // Exponenciación (potencia) 
    echo "La exponenciación de $num1 elevado a $num2 es: " . ($num1 ** $num2) . "<br>";
    ?>

</body>

</html>