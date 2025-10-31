<?php
// La función isset() determina si una variable está definida y no es null. Devuelve true si la variable existe y tiene un valor distinto de null, y false en caso contrario.
$variable = "Hola";

if (isset($variable)) {
    echo "1.-La variable está definida y no es null.<br>";
} else {
    echo "1.-La variable no está definida o es null.<br>";
}
// Salida: La variable está definida y no es null.

if (isset($otraVariable)) {
    echo "2.-Está definida.<br>";
} else {
    echo "2.-No está definida.<br>";
}
// Salida: No está definida.

//isset() devuelve false si la variable es null.
$variable_nula = null;
if (isset($variable_nula)) {
    echo "3.-La variable está definida y no es null.<br>";
} else {
    echo "3.-La variable no está definida o es null.<br>";
}

?>
