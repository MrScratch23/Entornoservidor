<?php

$datos = array(2,4,1,6,3,7,8);

$frutas = ["Manzana", "Platano", "Kiwi", "Pera"];

$combinado = array_merge($datos, $frutas);

echo "<pre>";
print_r($combinado);
echo "</pre>";

?>