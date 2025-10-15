<?php

$alfabeto = ["a", "b", "d", "e", "f", "g", "h", "i", "j", "k", "l", "m", "n", "ñ", "o", "p", "q", "r", "s", "t", "u", "v", "w", "x", "y", "z"];


// comprobar que existe el archivo


function cifradorCesar ($texto)  {

}






if ($_SERVER['REQUEST_METHOD'] === 'GET') {

    $errores = "";
    
    $texto = isset($_GET['texto']) ? htmlspecialchars($_GET['texto']) : '';
    $numero = isset($_GET['numero']) ? htmlspecialchars($_GET['numero']) : '';
    $guardar = isset($_GET['guardar']) ? htmlspecialchars($_GET['guardar']) : '';
    $cifrar = isset($_GET['cifrar']) ? htmlspecialchars($_GET['cifrar']) : '';

    if (empty($texto)) {
         $errores .= "El texto no puede estar vacio.";
            return;
    }

    if (empty($numero)) {
        $errores .= "El numero no puede estar vacio. ";
        return;
    }

    $posicion = intval($numero);


    if ($posicion === 0) {
        $errores .= "El numero introducido debe ser mayor o menor que 0";
        return;
    } 
    
    // cifradorCesar($texto);


  
}




?>


<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario</title>
    <link rel="stylesheet" href="https://cdn.simplecss.org/simple.min.css">
</head>

<body>

    <form action="/enviar" method="get">
        <label for="texto">Texto:</label>
        <input type="text" id="texto" name="texto" required>

        <label for="numero">Número:</label>
        <input type="number" id="numero" name="numero" required>

        <label for="guardar">
            <input type="checkbox" id="guardar" name="guardar" value="guardar">
            Guardar
        </label>

        <label for="cifrar">Cifrar la frase:</label>
        <input type="submit" value="Enviar" name="cifrar" id="cifrar">
    </form>
    <?php
    
    echo $mensaje;
    
    ?>

</body>

</html>
