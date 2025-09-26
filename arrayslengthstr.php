<?php
$texto = "Esto es un ejemplo";
echo 'Longitud del texto "' . $texto . '": ' . strlen($texto) . ' caracteres<br>';

// Convertir a mayúsculas
$textoMayus = strtoupper($texto);

// Convertir a minúsculas
$textoMinus = strtolower($texto);

echo 'Texto en mayúsculas: ' . $textoMayus . '<br>';
echo 'Texto en minúsculas: ' . $textoMinus . '<br>';
?>
