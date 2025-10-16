<?php
$mensaje = "";
// $texto = isset($_POST['texto']) ? htmlspecialchars($_POST['texto']) : '';
$texto = htmlspecialchars($_POST['texto']) ?? '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $n_palabras = str_word_count($texto);
    $longitud_texto = strlen($texto);
    $n_lineas = trim($texto) === '' ? 0 : substr_count($texto, "\n") + 1;
    $n_espacios = substr_count($texto, " ");
    $porcentaje_espacios = $longitud_texto > 0 ? ($n_espacios / $longitud_texto) * 100 : 0;
    $n_vocales = 0;

    if (empty($texto)) {
        $mensaje .= "El texto no puede estar vacío. ";
    }

    if ($longitud_texto >= 500) {
        $mensaje .= "El texto no puede exceder los 500 caracteres. ";
    } else {
        $mensaje .= "El texto contiene $longitud_texto caracteres. ";
    }

    $mensaje .= "Número de palabras: $n_palabras. ";
    $mensaje .= "Número de líneas: $n_lineas. ";

    $aeiou = "aeiouAEIOUáéíóúÁÉÍÓÚ";
    for ($i = 0; $i < $longitud_texto; $i++) { 
        $char = $texto[$i];
        if (strpos($aeiou, $char) !== false) {
            $n_vocales++;
        }
    }
    $mensaje .= "Número de vocales: $n_vocales. ";
    $mensaje .= "Porcentaje de espacios en blanco: " . round($porcentaje_espacios, 2) . "%.";
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Analizador de texto</title>
    <link rel="stylesheet" href="https://cdn.simplecss.org/simple.min.css">
</head>
<body>
    <form method="post">
        <label for="texto">Ingrese su texto:</label><br />
        <textarea id="texto" name="texto" rows="5" cols="40" placeholder="Escribe aquí..."><?php echo htmlspecialchars($texto); ?></textarea><br />
        <button type="submit">Enviar</button>
    </form>

    <?php if (!empty($mensaje)): ?>
        <p><?php echo $mensaje; ?></p>
    <?php endif; ?>
</body>
</html>
