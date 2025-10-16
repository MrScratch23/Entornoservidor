<?php

$mensaje = "";
$errores = "";

function cifradorCesar($texto, $numero) {
    $resultado = "";
    $alfabeto = ["a", "b", "c", "d", "e", "f", "g", "h", "i", "j", "k", "l", "m", "n", "ñ", "o", "p", "q", "r", "s", "t", "u", "v", "w", "x", "y", "z"];
    $longitud = count($alfabeto);

    // usamos mb_strlen para contar bien los caracteres, no los bytes
    $longTexto = mb_strlen($texto, 'UTF-8');

    for ($i = 0; $i < $longTexto; $i++) {
        // cogemos la letra original (usando mb_substr para manejar multibyte como la ñ)
        $letraOriginal = mb_substr($texto, $i, 1, 'UTF-8');
        // la pasamos a minuscula usando el mb y el utf8 por si acaso
        $letra = mb_strtolower($letraOriginal, 'UTF-8');
        // sacamos el numero de donde esté esta letra buscando en el array de alfabeto
        $pos = array_search($letra, $alfabeto);

        // si es diferente a false (que encontró la letra), ya la agregamos al cifrado
        if ($pos !== false) {
            $nuevaPos = ($pos + $numero) % $longitud;
            if ($nuevaPos < 0) {
                $nuevaPos += $longitud;
            }
            // hay que ver si estaba en mayúsculas o no (comparando en UTF-8 también)
            if (mb_strtoupper($letraOriginal, 'UTF-8') === $letraOriginal) {
                // pasamos la letra a mayúscula
                $resultado .= mb_strtoupper($alfabeto[$nuevaPos], 'UTF-8');
            } else {
                $resultado .= $alfabeto[$nuevaPos];
            }
        } else {
            // si no está en el alfabetose deja tal cual
            $resultado .= $letraOriginal;
        }
    }

    return $resultado;
}


if ($_SERVER['REQUEST_METHOD'] === 'GET') {


    // comprobacion del formulario
    $texto = isset($_GET['texto']) ? htmlspecialchars($_GET['texto']) : '';
    $numero = isset($_GET['numero']) ? htmlspecialchars($_GET['numero']) : '';
    $guardar = isset($_GET['guardar']) ? htmlspecialchars($_GET['guardar']) : '';
    $cifrar = isset($_GET['cifrar']) ? htmlspecialchars($_GET['cifrar']) : '';

    // validar
    if (empty($texto)) {
        $errores .= "El texto no puede estar vacío. <br>";
    }

    if (empty($numero)) {
        $errores .= "El número no puede estar vacío.<br>";
    }

    $posicion = intval($numero);

    if ($posicion === 0) {
        $errores .= "El número introducido debe ser mayor o menor que 0.<br>";
    }

    if (!empty($errores)) {
        $mensaje .= $errores;
    } else {
        $resultado = cifradorCesar($texto, $posicion);
        $mensaje .= "Texto cifrado: <strong>$resultado</strong><br>";

    // crear el fichero
        if ($guardar === "guardar") {
            $archivo = "cifrado.txt"; 
            $fichero = @fopen($archivo, "a");

            if ($fichero) {
            fwrite($fichero, $resultado . "\n");
            fclose($fichero);
            $mensaje .= "Texto guardado en el archivo.<br>";
            } else {
            $mensaje .= "No se pudo abrir o crear el archivo.<br>";
            }
        }
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

    <form action="" method="get">
        <label for="texto">Texto:</label>
        <input type="text" id="texto" name="texto" value="<?= htmlspecialchars($texto ?? '') ?>">

        <label for="numero">Número:</label>
        <input type="number" id="numero" name="numero" value="<?= htmlspecialchars($numero ?? '') ?>">

        <label for="guardar">
            <input type="checkbox" id="guardar" name="guardar" value="guardar" <?= (isset($guardar) && $guardar === "guardar") ? "checked" : "" ?>>
            Guardar
        </label>

        <label for="cifrar">Cifrar la frase:</label>
        <input type="submit" value="Enviar" name="cifrar" id="cifrar">
    </form>

    
    <?php if (!empty($mensaje)): ?>
        <p class="notice"><?= $mensaje ?></p>
    <?php endif; ?>

</body>
</html>

