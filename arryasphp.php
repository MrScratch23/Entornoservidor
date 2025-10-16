<?php
// formas de declarar arrays

$colores = array("Rojo", "Verde", "Amarillo");
// $colores = ["Rojo", "Verde", "Amarillo"];

/*
[0] -> Rojo
[1] -> Verde
[2] -> Amarillo
*/

echo "El primer color es: $colores[0] <br>";
echo "El tercer color es: $colores[2]<br>"; // ← Faltaba el punto y coma

// podemos cambiar el valor
$colores[1] = "Naranja";

// Mostramos el nuevo valor
echo "El segundo color ahora es: $colores[1]<br>";
// tambien podemos usar pre

?>

