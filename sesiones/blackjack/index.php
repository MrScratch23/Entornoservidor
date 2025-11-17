
<?php
session_start();
include "usuarios.php";

if (isset($_SESSION['usuario'])) {
    header("Location: juego.php", true, 302);
}

$errores = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usuario = htmlspecialchars(trim($_POST['usuario'])) ?? '';
    $password = $_POST['password'] ?? '';
  
    if (empty($usuario)) {
        $errores['usuario'] = "El campo de usuario no puede estar vacio";
    }

    if (empty($password)) {
        $errores['password'] = "El campo de password no puede estar vacio";
    }


    if (empty($errores)) {
            if (isset($usuarios[$usuario]) && $usuarios[$usuario] === $password) {
          $_SESSION['usuario'] = $usuario;
          header("Location: juego.php", true, 302);
          exit();
    } else {
        $errores['mensajeError'] = "Usuario o contraseña incorrectos.";
    }

    }



}


?>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blackjack - Login</title>
    <link rel="stylesheet" href="https://cdn.simplecss.org/simple.min.css">
</head>
<body>
    <h1>♠️ ♥️ Blackjack Online ♦️ ♣️</h1>
    
    <h2>Identificación del Jugador</h2>
    
    <form method="post" action="">
        <label for="usuario">Usuario:</label>
        <input type="text" id="usuario" name="usuario">
        <span><?php if (isset($errores['usuario'])) {
            echo $errores['usuario'];
        } ?></span>
        
        <label for="password">Contraseña:</label>
        <input type="password" id="password" name="password">
        <span><?php
        if (isset($errores['password'])) {
            echo $errores['password'];
        }
        ?></span>
        <br>
        <button type="submit">Comenzar a Jugar</button>
        <span> <?php
        if (isset($errores['mensajeError'])) {
            echo $errores['mensajeError'];
        }
        ?></span>
    </form>
</body>
</html>