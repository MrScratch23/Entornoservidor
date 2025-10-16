<?php


$a = 4; // Asignacion inicial
$b = $a; // Asignacion por copia
// usando aspersan podemos vincular las variables en vez de clonarlas

// $b = &$a;

// Imprimos para que se vean
echo "Valor de a: $a<br>";
echo "Valor de b: $a<br>";

// Modificamos para que se vea de forma diferente

echo "Cambiamos el valor de b <br>";

$b += 5; // le añadimos 5 a b

echo "Valor de a: $a<br>";
echo "Valor de b: $b<br>";




?>