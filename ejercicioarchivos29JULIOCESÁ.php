<?php

$mensaje = "";
$errores ="";
// comprobar que existe el archivo


function cifradorCesar ($texto, $numero)  {
    $resultado ="";
    $alfabeto = ["a", "b", "d", "e", "f", "g", "h", "i", "j", "k", "l", "m", "n", "ñ", "o", "p", "q", "r", "s", "t", "u", "v", "w", "x", "y", "z"];


    $longitud = count($alfabeto);
    $texto = strtolower($texto);

    for ($i=0; $i < $longitud; $i++) { 
        if ($texto[$i] == $alfabeto [$i]) {
            $nuevaLetra = $alfabeto [$i +$numero];
            $texto [$i] = $nuevaLetra;
            $resultado .= $texto [$i];
        }
    }


    return $resultado;

}






if ($_SERVER['REQUEST_METHOD'] === 'GET') {

   
    
    $texto = isset($_GET['texto']) ? htmlspecialchars($_GET['texto']) : '';
    $numero = isset($_GET['numero']) ? htmlspecialchars($_GET['numero']) : '';
    $guardar = isset($_GET['guardar']) ? htmlspecialchars($_GET['guardar']) : '';
    $cifrar = isset($_GET['cifrar']) ? htmlspecialchars($_GET['cifrar']) : '';

    if (empty($texto)) {
         $errores .= "El texto no puede estar vacio. <br>";
            
    }

    if (empty($numero)) {
        $errores .= "El numero no puede estar vacio.<br> ";
        
    }

    $posicion = intval($numero);


    if ($posicion === 0) {
        $errores .= "El numero introducido debe ser mayor o menor que 0 <br>";
        
    } 
    
    if (!empty($errores)) {
        $mensaje .= $errores;
    }


  
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

    <form action=""  method="get">
        <label for="texto">Texto:</label>
        <input type="text" id="texto" name="texto">

        <label for="numero">Número:</label>
        <input type="number" id="numero" name="numero">

        <label for="guardar">
            <input type="checkbox" id="guardar" name="guardar" value="guardar">
            Guardar
        </label>

        <label for="cifrar">Cifrar la frase:</label>
        <input type="submit" value="Enviar" name="cifrar" id="cifrar">
        <br>
        <?php
    
    echo "<p class=notice> $mensaje</p>";
    
    ?>
    </form>
    

</body>

</html>
