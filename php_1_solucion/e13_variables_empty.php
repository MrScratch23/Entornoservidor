<?php
/*
La función empty() evalúa si una variable está vacía. Se considera "vacía" si tiene uno de los siguientes valores:
0 (entero)
"0" (cadena)
"" (cadena vacía)
null
false
Un array vacío
Una variable no definida
*/
$var1 = "";        // Variable vacía (isset->true, empty->true)
$var2 = 0;        // Variable con valor 0 (isset->true, empty->true)
$var3 = null;     // Variable con valor null (isset->false, empty->true)
$var4 = "Hola";   // Variable con un valor no vacío (isset->true, empty->false)

// Comprobamos si cada variable está vacía
echo "Comprobando \$var1: " . (empty($var1) ? "La variable está vacía" : "La variable no está vacía") . "<br>";
echo "Comprobando \$var2: " . (empty($var2) ? "La variable está vacía" : "La variable no está vacía") . "<br>";
echo "Comprobando \$var3: " . (empty($var3) ? "La variable está vacía" : "La variable no está vacía") . "<br>";
echo "Comprobando \$var4: " . (empty($var4) ? "La variable está vacía" : "La variable no está vacía") . "<br>";
//echo gettype($var3);
?>
