
<?php
// iniciamos la session para comprobar
session_start();
// preguntamos si existe el usuario
if (!isset($_SESSION['usuario'])) {
    // si no existe la variable sesion de usuario
  header("Location:login.php", true, 302);
  exit();
}

$usuario = $_SESSION['usuario'];

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdn.simplecss.org/simple.min.css">
</head>
<body>
    <h1> HOLA MUNDO</h1>
    <h3> Bienvenido <?=htmlspecialchars($usuario);?></h3> 
    <p><a href="logout.php"> Cerrar sesion</a></p>
</body>
</html>