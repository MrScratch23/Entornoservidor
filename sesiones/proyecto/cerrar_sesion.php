<?php
// CERRAR_SESION.PHP

// 1. INICIAR SESIÓN
session_start();

function guardarArrayAsociativoTXT($archivo, $arrayAsociativo) {
    $lineas = [];
    foreach ($arrayAsociativo as $clave => $valor) {
        $lineas[] = "$clave: $valor";
    }
    file_put_contents($archivo, implode("\n", $lineas) . "\n\n", FILE_APPEND);
    return true;
}

// 2. GUARDAR ESTADÍSTICAS FINALES
if (isset($_SESSION['usuario'])) {
    $archivo = "data/estadisticas.txt";
    $estadisticas = [
        "usuario" => $_SESSION['usuario'],
        "puntos" => $_SESSION['puntos'],
        "aciertos" => $_SESSION['aciertos'],
        "fallos" => $_SESSION['fallos'],
        "fecha" => date('Y-m-d H:i:s'),
    ];

    guardarArrayAsociativoTXT($archivo, $estadisticas);
    
    // 3. DESTRUIR LA SESIÓN COMPLETAMENTE
    session_destroy();
    
    // 4. REDIRIGIR A index.php
    header("Location: index.php", true, 302);
    exit();
} else {
    header("Location: index.php", true, 302);
    exit();
}
?>