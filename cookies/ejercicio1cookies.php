
<?php

$mensaje = "";
$contador = 0;


if(isset($_COOKIE['primeracookie'])){
   
    $contador = $_COOKIE['primeracookie'] + 1;
 
    setcookie("primeracookie", $contador, time() + (7*24*60*60), "/");
} else {

    $contador = 0;
    setcookie("primeracookie", $contador, time() + (7*24*60*60), "/");
}

$mensaje = "Contador: ";
// añadir el valor de la cookie al mensaje
$mensaje .= $_COOKIE['primeracookie'];



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
    <?php
    // Mostrar el mensaje
    echo "<p class=notice>$mensaje</p>";
    
    ?>


    
</body>

</html>