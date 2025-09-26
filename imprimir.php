
<?php
   $nombre = $_GET["nombre"];
   $apellidos = $_GET["apellidos"];


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
    <main>
        <h2>
           Mostramos los datos
        </h2>
       
          <?php
          echo "<h2> Bienvenido $nombre $apellidos </h2>";
          
          ?>
        <a href="peticionget.php">Volver</a>

    </main>
    
</body>
</html>