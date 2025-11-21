<?php
require_once "funcionesBDD.php";



$conexion = conectarBDD();
$idproducto = htmlspecialchars(trim($_GET['id_producto'])) ?? '';

if (!ctype_digit($idproducto)) {
    header("Location: tienda.php", true, 302);
    exit();
}

$mensaje = ""; 


$stmt = $conexion->prepare("DELETE FROM productos WHERE id_producto=?");
$stmt->bind_param("i", $idproducto);
$stmt->execute(); 

if ($stmt->affected_rows > 0) {
    $mensaje = "Producto eliminado de forma exitosa";
    // limpiar campos después de éxito
    $idproducto = "";
    // Después de eliminar exitosamente
header("Location: mostrar_tabla.php?mensaje=Producto+eliminado+exitosamente");
exit();
} else {
    $mensaje = "No se pudo eliminar el producto o no existe";
}

$stmt->close();
?>

