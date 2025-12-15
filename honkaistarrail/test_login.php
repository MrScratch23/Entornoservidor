<?php
echo "<h1>🔧 TEST DE LOGIN</h1>";

// 1. Incluir archivos
require_once 'includes/config.php';
require_once APP_ROOT . "/models/LoginModel.php";

// 2. Crear instancia
$loginModel = new LoginModel();
echo "✅ LoginModel creado<br>";

// 3. Probar con admin/admin123
$username = "admin";
$password = "admin123";

echo "<h3>Probando con:</h3>";
echo "Usuario: $username<br>";
echo "Contraseña: $password<br>";

// 4. Ejecutar autentificación
$resultado = $loginModel->autentificarUsuario($username, $password);

echo "<h3>Resultado:</h3>";
if ($resultado === false) {
    echo "❌ FALSO - No autenticado<br>";
    
    // Verificar si el usuario existe
    echo "<h4>Depuración SQL:</h4>";
    
    // Probemos el SQL directamente
    $sql = "SELECT * FROM usuarios WHERE username = ?";
    $db = new Database();
    $datos = $db->executeQuery($sql, [$username]);
    
    if (empty($datos)) {
        echo "⚠️ El usuario '$username' NO EXISTE en la BD<br>";
        echo "Ejecuta en MySQL: SELECT * FROM usuarios;<br>";
    } else {
        echo "✅ Usuario encontrado en BD<br>";
        echo "Hash almacenado: " . substr($datos[0]['password_hash'], 0, 30) . "...<br>";
        echo "Longitud hash: " . strlen($datos[0]['password_hash']) . "<br>";
        
        // Probar password_verify manualmente
        $hash = $datos[0]['password_hash'];
        $verificado = password_verify($password, $hash);
        echo "password_verify manual: " . ($verificado ? '✅ TRUE' : '❌ FALSE') . "<br>";
    }
} else {
    echo "✅ ÉXITO - Usuario autenticado:<br>";
    echo "<pre>";
    print_r($resultado);
    echo "</pre>";
}
?>