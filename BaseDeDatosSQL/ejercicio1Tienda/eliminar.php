<?php
    require_once "funcionesBDD.php";

$host = "localhost";
$user = "usuario_tienda";
$password = "1234";
$base = "tienda";

    $conexion = conectarBDD($host, $user, $password, $base);
    $idproducto = htmlspecialchars(trim($_GET['id_producto'])) ?? '';

    if (!ctype_digit($idproducto)) {
        header("Location: tienda.php", true, 302);
        exit();
    }

     
    // forma segura con stmt
    $stmt = $conexion->prepare("DELETE FROM productos where id='?'");
            $stmt->bind_param("i", $idproducto);
            $stmt->execute(); 

            if ($stmt->affected_rows > 0) {
                $mensaje = "Producto eliminador de forma exitosa";
                // limpiar campos después de éxito
                $idproducto = "";
                
            } 
            $stmt->close();
       
    

?>