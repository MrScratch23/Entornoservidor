<?php
$edad = 25;
$ciudad = "Sevilla";

// Usando comillas dobles
echo "<p>Vivo en $ciudad y tengo $edad años.</p>";

// Usando comillas simples (no evalúan variables)
echo '<p>Vivo en $ciudad y tengo $edad años.</p>';
echo '<p>Vivo en ' . $ciudad . ' y tengo ' . $edad . ' años.</p>';
?>
