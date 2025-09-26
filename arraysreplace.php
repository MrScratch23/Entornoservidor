<?php
// Crear la variable original
$frase = "PHP es un lenguaje divertido y poderoso.";

// Reemplazar "divertido" por "fácil"
$nuevaFrase = str_replace("divertido", "fácil", $frase);

// Mostrar ambas frases
echo "Frase original: " . $frase . "<br>";
echo "Frase modificada: " . $nuevaFrase . "<br><br>";

// Reemplazar múltiples palabras a la vez: "PHP" por "JavaScript" y "poderoso" por "versátil"
$nuevaFraseMultiple = str_replace(
    ["PHP", "poderoso"],
    ["JavaScript", "versátil"],
    $frase
);

// Mostrar el resultado de reemplazos múltiples
echo "Frase con reemplazos múltiples: " . $nuevaFraseMultiple;
?>
