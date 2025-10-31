<?php
// Declaración de dos variables
$var1 = 10;  // Número entero
$var2 = "10";  // Cadena de texto

// Comparación usando el operador ==
echo "¿\$var1 es igual a \$var2 (==)? ";
echo ($var1 == $var2) ? "Sí<br>" : "No<br>";  // Muestra Sí (compara solo el valor, no el tipo)

// Comparación usando el operador ===
echo "¿\$var1 es estrictamente igual a \$var2 (===)? ";
echo ($var1 === $var2) ? "Sí<br>" : "No<br>";  // Muestra No (compara valor y tipo)

// Comparación usando el operador !=
echo "¿\$var1 es diferente a \$var2 (!=)? ";
echo ($var1 != $var2) ? "Sí<br>" : "No<br>";  // Muestra No (compara solo el valor)

// Comparación usando el operador !==
echo "¿\$var1 es estrictamente diferente a \$var2 (!==)? ";
echo ($var1 !== $var2) ? "Sí<br>" : "No<br>";  // Muestra Sí (compara valor y tipo)
