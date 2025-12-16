<?php
// test-config.php
echo "Ruta de este archivo: " . __FILE__ . "<br>";
echo "Directorio: " . __DIR__ . "<br>";

// Probar diferentes formas de incluir
$paths = [
    dirname(__DIR__) . "/includes/config.php",
    dirname(__DIR__) . "\\includes\\config.php",
    __DIR__ . "/../includes/config.php"
];

foreach ($paths as $path) {
    if (file_exists($path)) {
        echo "✅ Config encontrado en: $path<br>";
        require_once $path;
        break;
    }
}

// Verificar constantes
if (defined("BD_HOST")) {
    echo "✅ BD_HOST = " . BD_HOST . "<br>";
} else {
    echo "❌ BD_HOST no definido<br>";
}
?>