<?php

function contador() {
    static $cuenta = 0;  // Declaramos la variable estática
    $cuenta++;           // Incrementamos el contador
    echo "La función ha sido llamada $cuenta veces.<br>";  // Mostramos el número de llamadas
}

// Llamamos a la función tres veces
contador();  // Muestra: La función ha sido llamada 1 veces.
contador();  // Muestra: La función ha sido llamada 2 veces.
contador();  // Muestra: La función ha sido llamada 3 veces.
?>
