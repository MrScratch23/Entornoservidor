<?php

$frutas = ["Manzana", "Platano", "Kiwi", "Pera"];


// modificamos un elemento del array
$frutas [3] = "Sandía";

// añadir elemento al array
$frutas [] = "Naranja";


// imprimimos el array
echo "<pre>";
print_r($frutas);
echo "</pre>";

// probamos la funcion implode
$a = implode("," , $frutas);
echo "$a";

// probamos la funcion explode, que convierte en arrays
$b = "pepe;juan;pedro;ana;rosa";

$personas = explode(";", $b);

echo "<pre>";
print_r($personas);
echo "</pre>";


?>
