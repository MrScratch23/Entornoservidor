<?php


$variable = "Hola";

// La variable definida da true

if (isset($variable)) {
    # code...
    echo "La variable esta definida"; 
} else {
    echo "La variable no esta definida"; 
}

// La variable definida da false si no existe
if (isset($otravariable)) {
    echo "La variable no existe";
} else {
    echo "La variable existe";
}


//  empty para ver si las variables estan vacias

empty($variable);







?>
