<?php


$a = "Mi variable a";

function mensaje() {

    // solo funciona dentro
    $a = "Hola mundo";

    // para hacer que la variable sea goblal 
    // global $a;
    echo 'La variable $a vale: ' . $a . '';
    // array de variables globales, para meter varias a la vez
    // $GLOBALS['a'];

}

echo ' La palabra a vale: ' . $a . '<br>';

echo "llamamos  la funcion -><br>";

mensaje();

?>