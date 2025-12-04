<?php
// conexion.php
// EJERCICIO 1: Conexión básica a MySQL

// TODO: Configurar variables de conexión
define('BD_HOST', 'localhost');  
define('BD_NAME', 'honkai_star_rail');  
define('BD_USER', 'honkai');      
define('BD_PASS', '1234');       



// TODO: Crear conexión con mysqli

$conexion = new mysqli(BD_HOST, BD_USER, BD_PASS, BD_NAME); 

// TODO: Verificar si hay error

if ($conexion->connect_error) {
       die("❌ Error de conexión: " . $conexion->connect_error);
}

// TODO: Si no hay error, mostrar mensaje de éxito
echo "✅ Conexión exitosa a la base de datos: " . BD_NAME;

// TODO: Cerrar conexión

$conexion->close();
?>