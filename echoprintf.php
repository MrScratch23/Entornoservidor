<?php
$nombre = "Ruben";

// Imprimir variables usando echo
echo "Mi nombre es $nombre.<br>";              // Se interpreta la variable
echo 'Mi nombre es $nombre.<br>';              // NO se interpreta la variable
echo 'Mi nombre es ' . $nombre . '.<br>';      // Concatenación correcta

// Usando printf correctamente
printf("Mi nombre es %s.<br>", $nombre);       // Correcto
printf("Mi nombre es %s.<br>", $nombre);       // También correcto (usando comillas dobles)


?>
