<?php
// Definir la constante para el IVA
//define('IVA', 0.21);
const IVA = 0.21;
// Precio base del producto
$precioBase = 101; // Puedes cambiar este valor según necesites

// Calcular el precio final
$precioFinal = $precioBase + ($precioBase * IVA);

// Mostrar el precio final
//echo "El precio final del producto es: $precioFinal €";
printf("El precio final del producto es: %.2f €",$precioFinal );
// echo "El precio final del producto es: " . number_format($precioFinal, 2) . " €";
?>
