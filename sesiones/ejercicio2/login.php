<?php


session_start();

// si ya existe, lo redigirmos ya a la pagina
if (isset($_SESSION['usuario'])) {
  header("Location:bienvenida.php", true, 302);
  exit();
}

// inicializar las variables para evitar warnings
$nombre = "";
$passsword = "";
$errores = [];
$mensaje = "";


$usuarios = array(
  "pepe" => "1234",
  "juan" => "3333",
  "ana" => "1111"
);



if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['acceder'])) {
  $nombre = htmlspecialchars(trim($_POST['usuario'])) ?? '';
  $password = htmlspecialchars(trim($_POST['password'])) ?? '';

  if ($nombre === "") {
    $errores['usuario'] = "Usuario es requerido.";
  }
  if ($password === "") {
    $errores['password'] = "Password es requerido.";
  }


  // si no hay errores, comprobamos el usuario y el password
  if (empty($errores)) {
    if (isset($usuarios[$nombre]) && $usuarios[$nombre] == $password) {
      $mensaje = "Usuario y password correctos.";
      // guardar en sesion el usuario
      $_SESSION['usuario'] = $nombre;
      header("Location:bienvenida.php", true, 302);
      exit();
    } else {
      $mensaje = "Usuario y password incorrectos.";
    }
  }
}


?>

<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link rel="stylesheet" href="https://cdn.simplecss.org/simple.min.css">
</head>

<body>

  <form action="" method="post">
    <label for="nombre">Usuario:</label>
    <input type="text" id="usuario" name="usuario">
    <span style="color:red;">
      <?php
      if (isset($errores['usuario'])) {
        echo $errores['usuario'];
      }
      ?>
    </span>
    <label for="password">Contraseña:</label>
    <input type="password" id="password" name="password">
    <span style="color:red;">
      <?php
      if (isset($errores['password'])) {
        echo $errores['password'];
      }
      ?>
    </span>
    <label><br>
      <button id="acceder" type="submit" name="acceder">Acceder</button>
    </label>
  </form>
  <?php
  if ($mensaje != "") {
    // impimir el mensaje
    echo "<p>" . $mensaje . "</p>";
  }

  ?>



</body>

</html>