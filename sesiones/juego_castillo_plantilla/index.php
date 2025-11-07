<?php 
session_start();


  // $_SESSION los puntos = 0, aciertos=0, fallos=0, turno=1
$_SESSION['puntos']=0;
$_SESSION['aciertos']=0;
$_SESSION['fallos']=0;
$_SESSION['turnos']=1;

if (isset($_SESSION['usuario'])) {
    header("Location:juego.php", true, 302);
    exit();
}

$mensaje = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = htmlspecialchars(trim($_POST['nombre'])) ?? '';

    if (empty($nombre)) {
        $mensaje = "El nombre no puede estar vacio. ";
    } else {

    $_SESSION['usuario'] = $nombre;
    header("Location:juego.php", true, 302);
    exit();
    }

}

?>

<!DOCTYPE html>
<html>
<head><meta charset="UTF-8"><title>Guardia del Castillo</title>
<link rel='stylesheet' href='css/estilos.css'>

</head>

<body>
    <h1>Bienvenido a las Puertas del Castillo</h1>
    <form action="" method="post">
        <label>Tu nombre:</label>
        <input type="text" name="nombre">
        <button type="submit">Entrar en servicio</button>
    </form>
    <p class='error'>
    <?php
    if (!empty($mensaje)) {
        echo $mensaje;
    }

    ?>

    </p>
  
</body>
</html>