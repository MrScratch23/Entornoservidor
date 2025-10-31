<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php
    $a = 10;
    $b = 11;
    echo "a: $a <br>";
    echo "b: $b <br>";
    echo "comparamos ambas variables <br>"; //ojo con la prioridad de operadores.
    echo " a > b ". ($a>$b) . "<br>"; //mejor poner false, porque no lo pinta.
    echo " a <= b ". ($a<=$b) . "<br>";
    
    ?>
</body>
</html>