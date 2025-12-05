<?php
require_once 'includes/config.php';
require_once APP_ROOT . "/includes/Database.php";

$db = new Database();

// 1. Ver qué hay en la base de datos para 'admin'
$sql = "SELECT password FROM usuarios WHERE usuario = 'admin'";
$result = $db->executeQuery($sql);

echo "<h3>Debug de Contraseñas</h3>";
echo "Contraseña almacenada para 'admin':<br>";
if (!empty($result)) {
    $hash = $result[0]['password'];
    echo "Hash: <code>$hash</code><br>";
    echo "Longitud: " . strlen($hash) . " caracteres<br>";
    
    // 2. Probar diferentes métodos
    echo "<h4>Pruebas:</h4>";
    
    // Prueba 1: password_verify con 'password'
    $test1 = password_verify('password', $hash);
    echo "password_verify('password', hash): " . ($test1 ? '✅ VERDADERO' : '❌ FALSO') . "<br>";
    
    // Prueba 2: password_verify con 'admin123'
    $test2 = password_verify('admin123', $hash);
    echo "password_verify('admin123', hash): " . ($test2 ? '✅ VERDADERO' : '❌ FALSO') . "<br>";
    
    // Prueba 3: SHA256 con 'password'
    $sha256_hash = hash('sha256', 'password');
    $test3 = ($hash === $sha256_hash);
    echo "SHA256('password') === hash: " . ($test3 ? '✅ VERDADERO' : '❌ FALSO') . "<br>";
    echo "SHA256 de 'password': <code>$sha256_hash</code><br>";
    
    // Prueba 4: SHA256 con 'admin123'
    $sha256_hash2 = hash('sha256', 'admin123');
    $test4 = ($hash === $sha256_hash2);
    echo "SHA256('admin123') === hash: " . ($test4 ? '✅ VERDADERO' : '❌ FALSO') . "<br>";
    
    // Prueba 5: Texto plano
    $test5 = ($hash === 'password');
    echo "Texto plano 'password': " . ($test5 ? '✅ VERDADERO' : '❌ FALSO') . "<br>";
    
    $test6 = ($hash === 'admin123');
    echo "Texto plano 'admin123': " . ($test6 ? '✅ VERDADERO' : '❌ FALSO') . "<br>";
    
} else {
    echo "Usuario 'admin' no encontrado";
}

// 3. Listar todos los usuarios
echo "<h4>Todos los usuarios:</h4>";
$sql_all = "SELECT usuario, LEFT(password, 20) as hash_inicio, LENGTH(password) as len FROM usuarios";
$all_users = $db->executeQuery($sql_all);

echo "<table border='1'>";
echo "<tr><th>Usuario</th><th>Hash (primeros 20 chars)</th><th>Longitud</th></tr>";
foreach ($all_users as $user) {
    echo "<tr>";
    echo "<td>" . htmlspecialchars($user['usuario']) . "</td>";
    echo "<td><code>" . htmlspecialchars($user['hash_inicio']) . "...</code></td>";
    echo "<td>" . $user['len'] . "</td>";
    echo "</tr>";
}
echo "</table>";
?>