<?php

function palabraAleatoria() {

    $palabras = ["manzana", "pera", "platano", "crema", "tornillo"];

$indice = array_rand($palabras);
$palabraAleatoria = $palabras[$indice];

return $palabraAleatoria;

    
}

function reemplazar_palabra_guiones($palabra) {

    $palabraCambiada = explode("_", $palabra);
    return $palabraCambiada;
}



?>