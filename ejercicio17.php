<?php

function printArray($array) {
    echo "<pre>";
    echo print_r($array, true); // Captura la salida y la imprime
    echo "</pre>";
}

$frutas = array("Manzana", "Pera", "Naranja", "Platano");

printArray($frutas); // Faltaba el punto y coma

?>
