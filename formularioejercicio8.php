
<?php

$mensaje = "";
$texto = htmlspecialchars( $_POST['texto']) ?? '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $n_vocales = 0;

    if (empty($texto)) {
        $mensaje .= "El texto no puedo estar vacio. ";
    }

    $longitud_texto =strlen($texto);

    if ($longitud_texto >= 500) {
        $mensaje .= "El texto no puede exceder los 500 caracteres.";
    }

     $aeiou = "aeiouAEIOUáéíóúÁÉÍÓÚ"; // Vocales con acentos y mayúsculas

    for ($i = 0; $i < $longitud_texto; $i++) { 
        $char = $texto[$i];
        if (strpos($aeiou, $char) !== false) {
            $n_vocales++;
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

<form action="texto" method="post">
        <label for="texto">Ingrese su texto:</label><br />
        <textarea id="texto" name="texto" rows="5" cols="40" placeholder="Escribe aquí..."></textarea><br />
        <button type="submit">Enviar</button>
    </form>
    
</body>
</html>