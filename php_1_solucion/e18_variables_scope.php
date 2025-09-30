<?php
$saludo = "Hola desde fuera";  // Variable global

function modificarSaludo() {
    global $saludo;  // Usamos la palabra clave global para acceder a la variable global
    $saludo = "Hola desde dentro";  // Modificamos la variable global

    //mostrarmos el valor de la variable saludo dentro de la función
    echo "Dentro de la función: $saludo<br>";
    
    //otra forma 
    $GLOBALS['saludo'] = "Lo vuelvo a cambiar desde dentro";
}

// Llamamos a la función para modificar el saludo
modificarSaludo();
//mostrarmos el valor de la variable saludo fuera de la función
echo "Fuera de la función: $saludo<br>";
      
?>
