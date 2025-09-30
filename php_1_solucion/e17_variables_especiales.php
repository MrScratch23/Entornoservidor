<?php
// Mostrar la dirección IP del cliente
echo "Dirección IP del cliente: " . $_SERVER['REMOTE_ADDR'] . "<br>";

// Mostrar el agente de usuario (navegador del cliente)
echo "Agente de usuario: " . $_SERVER['HTTP_USER_AGENT'] . "<br>";
?>
