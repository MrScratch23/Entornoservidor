<?php
$entero = 10;
$cadena = "Hola";
$flotante = 10.5;
$booleano = true;

var_dump($entero);   // Muestra: int(10)
echo "<br>";
var_dump($cadena);   // Muestra: string(4) "Hola"
echo "<br>";
var_dump($flotante); // Muestra: float(10.5)
echo "<br>";
var_dump($booleano); // Muestra: bool(true)
echo "<br><br>";

// Modificar contenido de las variables con otros tipos
$entero = "ahora soy una cadena";
$cadena = 42;
$flotante = false;
$booleano = 7.89;

// Mostrar nuevo tipo y valor con var_dump()
var_dump($entero);   // Muestra: string(19) "ahora soy una cadena"
echo "<br>";
var_dump($cadena);   // Muestra: int(42)
echo "<br>";
var_dump($flotante); // Muestra: bool(false)
echo "<br>";
var_dump($booleano); // Muestra: float(7.89)
echo "<br>";

// Mostrar el tipo actual de cada variable con gettype()
echo "<p>El tipo de \$entero es: " . gettype($entero) . "</p>";   // string
echo "<p>El tipo de \$cadena es: " . gettype($cadena) . "</p>";   // integer
echo "<p>El tipo de \$flotante es: " . gettype($flotante) . "</p>"; // boolean
echo "<p>El tipo de \$booleano es: " . gettype($booleano) . "</p>"; // double
?>
