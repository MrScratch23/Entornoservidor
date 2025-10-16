<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <?php
    // Asignación inicial
    $numero = 10;  // Se asigna el valor 10 a la variable $numero
    echo "Valor inicial: " . $numero . "<br>";

    // Suma usando el operador de asignación +=
    $numero += 5;  // Es equivalente a $numero = $numero + 5
    echo "Después de usar +=: " . $numero . "<br>";  // Muestra 15

    // Multiplicación usando el operador de asignación *=
    $numero *= 2;  // Es equivalente a $numero = $numero * 2
    echo "Después de usar *=: " . $numero . "<br>";  // Muestra 30

    // Módulo usando el operador de asignación %=
    $numero %= 7;  // Es equivalente a $numero = $numero % 7
    echo "Después de usar %=: " . $numero . "<br>";  // Muestra el resto de la división entre 30 y 7, que es 2

    $a = 1;
    echo ++$a;
    //echo ($a++);
    echo "<br>";
    echo $a;

    ?>

</body>

</html>