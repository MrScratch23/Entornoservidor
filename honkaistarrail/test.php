<?php
// test-rutas.php - VERSIÓN CORREGIDA
echo "<h2>Test de Rutas</h2>";

echo "<h3>Información del sistema:</h3>";
echo "PHP OS: " . PHP_OS . "<br>";
echo "PHP Version: " . phpversion() . "<br>";
echo "DIRECTORY_SEPARATOR: '" . DIRECTORY_SEPARATOR . "'<br>";
echo "__DIR__: '" . __DIR__ . "'<br>";
echo "dirname(__DIR__): '" . dirname(__DIR__) . "'<br>";
echo "Document Root: '" . ($_SERVER['DOCUMENT_ROOT'] ?? 'NO DEFINIDO') . "'<br>";
echo "Script: '" . ($_SERVER['SCRIPT_FILENAME'] ?? 'NO DEFINIDO') . "'<br>";

echo "<h3>Archivos requeridos:</h3>";

// Primero, mostrar la estructura real
$base_dir = __DIR__;
echo "Directorio actual: $base_dir<br>";

$files_to_check = [
    'config.php' => [
        $base_dir . '/includes/config.php',
        dirname($base_dir) . '/includes/config.php',
        dirname($base_dir) . '\\includes\\config.php',
        realpath($base_dir . '/../includes/config.php'),
        realpath($base_dir . '\\..\\includes\\config.php')
    ],
    'Database.php' => [
        $base_dir . '/includes/Database.php',
        dirname($base_dir) . '/includes/Database.php',
        dirname($base_dir) . '\\includes\\Database.php',
        realpath($base_dir . '/../includes/Database.php'),
        realpath($base_dir . '\\..\\includes\\Database.php')
    ],
    'ComentarioPersonajeModel.php' => [
        $base_dir . '/models/ComentarioPersonajeModel.php',
        dirname($base_dir) . '/models/ComentarioPersonajeModel.php',
        dirname($base_dir) . '\\models\\ComentarioPersonajeModel.php',
        realpath($base_dir . '/../models/ComentarioPersonajeModel.php'),
        realpath($base_dir . '\\..\\models\\ComentarioPersonajeModel.php')
    ]
];

foreach ($files_to_check as $file_name => $paths) {
    echo "<h4>Buscando: $file_name</h4>";
    $found = false;
    
    foreach ($paths as $index => $path) {
        $exists = file_exists($path);
        $color = $exists ? 'green' : 'gray';
        echo "<span style='color:$color'>  [$index] $path - " . ($exists ? '✅ EXISTE' : '❌ NO EXISTE') . "</span><br>";
        
        if ($exists && !$found) {
            $found = $path;
            echo "<span style='color:blue;font-weight:bold'>  ✓ Usar esta ruta: $path</span><br>";
        }
    }
    
    if (!$found) {
        echo "<span style='color:red;font-weight:bold'>  ✗ Archivo NO encontrado en ninguna ruta</span><br>";
    }
    echo "<hr>";
}

echo "<h3>Estructura de directorios desde " . dirname(__DIR__) . ":</h3>";

function listDirectory($dir, $level = 0) {
    if (!is_dir($dir)) {
        echo "❌ No es un directorio válido: $dir<br>";
        return;
    }
    
    $items = @scandir($dir);
    if ($items === false) {
        echo "❌ Error al leer directorio: $dir<br>";
        return;
    }
    
    foreach ($items as $item) {
        if ($item == '.' || $item == '..') continue;
        
        $path = $dir . DIRECTORY_SEPARATOR . $item;
        $indent = str_repeat('&nbsp;&nbsp;&nbsp;&nbsp;', $level);
        
        if (is_dir($path)) {
            echo $indent . "📁 <strong>$item/</strong><br>";
            listDirectory($path, $level + 1);
        } else {
            $size = filesize($path);
            echo $indent . "📄 $item ($size bytes)<br>";
        }
    }
}

// Mostrar desde diferentes niveles
$dirs_to_show = [
    'Directorio actual' => __DIR__,
    'Un nivel arriba' => dirname(__DIR__),
    'Dos niveles arriba' => dirname(dirname(__DIR__))
];

foreach ($dirs_to_show as $label => $dir) {
    echo "<h4>$label ($dir):</h4>";
    if (is_dir($dir)) {
        listDirectory($dir);
    } else {
        echo "❌ No es un directorio válido<br>";
    }
    echo "<hr>";
}

echo "<h3>Constantes definidas:</h3>";
$constants = get_defined_constants(true)['user'] ?? [];
if (empty($constants)) {
    echo "No hay constantes de usuario definidas<br>";
} else {
    foreach ($constants as $name => $value) {
        echo "$name = " . (is_string($value) ? "'$value'" : $value) . "<br>";
    }
}

echo "<h3>Test de require_once:</h3>";

// Probar cargar Database.php
$db_paths = [
    dirname(__DIR__) . '\\includes\\Database.php',
    dirname(__DIR__) . '/includes/Database.php',
    __DIR__ . '/../includes/Database.php'
];

foreach ($db_paths as $db_path) {
    if (file_exists($db_path)) {
        echo "Probando: $db_path<br>";
        try {
            require_once $db_path;
            echo "<span style='color:green'>✅ Database.php cargado exitosamente</span><br>";
            
            // Probar instanciar
            try {
                $db = new Database();
                echo "<span style='color:green'>✅ Objeto Database creado</span><br>";
                
                // Probar consulta
                $test = $db->executeQuery("SELECT 1 as test");
                echo "<span style='color:green'>✅ Consulta a BD funcionó</span><br>";
                
                // Probar INSERT
                echo "<span style='color:blue'>ℹ️ Para probar INSERT, usa el test-comentario.php</span><br>";
                
            } catch (Exception $e) {
                echo "<span style='color:red'>❌ Error creando Database: " . $e->getMessage() . "</span><br>";
            }
            
        } catch (Exception $e) {
            echo "<span style='color:red'>❌ Error cargando: " . $e->getMessage() . "</span><br>";
        }
        break;
    }
}

echo "<h3>Crear archivo de prueba de rutas:</h3>";

$test_file = __DIR__ . '/test-config.php';
$test_content = '<?php
// test-config.php
echo "Ruta de este archivo: " . __FILE__ . "<br>";
echo "Directorio: " . __DIR__ . "<br>";

// Probar diferentes formas de incluir
$paths = [
    dirname(__DIR__) . "/includes/config.php",
    dirname(__DIR__) . "\\\\includes\\\\config.php",
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
?>';

file_put_contents($test_file, $test_content);
echo "Archivo creado: $test_file<br>";
echo "Ejecuta <a href='test-config.php'>test-config.php</a> para verificar rutas<br>";

echo "<h3>Recomendación:</h3>";
echo "1. Ejecuta este archivo primero<br>";
echo "2. Mira qué rutas EXISTEN<br>";
echo "3. Usa ESA ruta exacta en guardar-comentario.php<br>";
echo "4. Formato Windows usa: dirname(__DIR__) . '\\\\includes\\\\config.php'<br>";
?>