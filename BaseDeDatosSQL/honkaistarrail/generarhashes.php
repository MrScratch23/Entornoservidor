<?php
echo "<h1>🔐 HASHS REALES - Copia y pega en SQL</h1>";

$usuarios = [
    ['admin', 'admin123'],
    ['usuario1', 'user123'],
    ['trainer', 'trainer123'],
    ['seele_fan', 'seele456'],
    ['kafka_lover', 'kafka789'],
    ['pepe', '1234']
    
];

echo "<pre>SET SQL_SAFE_UPDATES = 0;\n";
// echo "DELETE FROM usuarios;\n";
echo "SET SQL_SAFE_UPDATES = 1;\n\n";
echo "INSERT INTO usuarios (username, email, password_hash, nombre, rol) VALUES\n";

foreach ($usuarios as $index => $usuario) {
    $username = $usuario[0];
    $password = $usuario[1];
    $hash = password_hash($password, PASSWORD_DEFAULT);
    $email = str_replace('_', '', $username) . '@honkai.com';
    $nombre = ucfirst(str_replace('_', ' ', $username));
    $rol = ($username === 'admin') ? "'admin'" : "'usuario'";
    
    $coma = ($index < count($usuarios) - 1) ? ',' : ';';
    
    echo "('$username', '$email', '$hash', '$nombre', $rol)$coma\n";
}

echo "</pre>";
?>