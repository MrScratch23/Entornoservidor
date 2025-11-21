<?php




function conectarBDD(){
    // establecer la conexion
   $host = "localhost";
$user = "usuario_tienda";
$password = "1234";
$base = "tienda"; 
$conexion = new mysqli($host, $user, $password, $base);

// comprobamos si todo salio bien
if ($conexion -> connect_error) {
    die('Error de conexion ' . $conexion -> connect_error);
} else {
    echo "Conexion establecida";
}

return $conexion;
}

function desconectarBDD(mysqli $conexion){
    $conexion ->close();
}

// $conexion = conectarBD($conexion);
// desconectarBD($conexion);

?>