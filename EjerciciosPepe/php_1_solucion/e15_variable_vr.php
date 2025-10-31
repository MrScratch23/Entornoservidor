<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <?php
    // Paso 1: Crear la variable $a
    $a = 10;
    echo "Valor inicial de \$a: " . $a . "\n"; // Muestra 10

    // Paso 2: Asignar por referencia
    $b = &$a; // Ahora $b hace referencia a $a
    echo "Valor inicial de \$b (referencia de \$a): " . $b . "\n"; // Muestra 10

    // Paso 3: Cambiar el valor de $b   
    $b = 20;
    echo "Valor de \$a después de cambiar \$b: " . $a . "\n"; // Muestra 20
    echo "Valor de \$b después de cambiar \$b: " . $b . "\n"; // Muestra 20
    
    //hacemos otro ejemplo con cadenas de texto.
    $persona1 = "Pepe";
    $persona2 = &$persona1;

    $persona2 = "Ana";
    echo "<br>Qué valor tiene persona1???: $persona1";
    
    ?>

</body>

</html>
<?php
/*$x = "Hola";               // Asignación inicial
$y = &$x;                  // Asignación por referencia
$y = "Mundo";              // Modificamos $y

echo "Valor de x: $x<br>"; // Muestra: Valor de x: Mundo
echo "Valor de y: $y<br>"; // Muestra: Valor de y: Mundo
*/ ?>