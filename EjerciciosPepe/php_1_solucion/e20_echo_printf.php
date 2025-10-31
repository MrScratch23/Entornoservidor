<?php
$nombre = "Juan";  // Define la variable con tu nombre

// Usando echo
echo "Mi nombre es $nombre.<br>";  // Usando comillas dobles
echo 'Mi nombre es $nombre.<br>'; // Usando comillas dobles
echo 'Mi nombre es ' . $nombre . '.<br>';  // Usando comillas simples con .

// Usando print
print "Mi nombre es $nombre"; // Usando comillas dobles
print 'Mi nombre es $nombre'; // Usando comillas simples 
print 'Mi nombre es ' . $nombre . '.<br>';  // Usando comillas simples con . -->error

printf("Mi nombre es %s.<br>", $nombre);  // Usando printf
printf('Mi nombre es %s.<br>', $nombre);  // Usando printf con comillas simples

// diferencias entre print y echo
/*Retorno de Valor:

echo: No devuelve ningún valor. Solo muestra la salida.
print: Devuelve 1, lo que significa que puede ser usado en expresiones o dentro de otras operaciones.*/

/*Uso como Función:

echo: No es realmente una función sino una construcción del lenguaje, por lo que no requiere paréntesis para pasar argumentos. Puede aceptar múltiples argumentos separados por comas.
print: Se comporta más como una función, aunque los paréntesis son opcionales. Solo acepta un argumento.*/


?>
