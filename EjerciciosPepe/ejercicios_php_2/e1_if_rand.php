<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <?php
        // almacenamos en una variable una temperatura aleatoria
        $temperatura = rand(-5, 45);
        //mostramos la temperatura
        echo "<h3>Temperatura: $temperatura"."º</h3>";
        // usamos una estructura de control para en funcion del valor mostrar un mensaje
        if ($temperatura >= 30) {
            echo "<p>Hace calor!</p>";
        } elseif ($temperatura < 15) {
            echo "<p>Hace frío!</p>";
        } else {
            echo "<p>El clima es templado</p>";
        }
    ?>
</body>

</html>
