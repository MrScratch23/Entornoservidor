<?php

$mensaje = "";
$errores = [];

$nombre = isset($_POST['nombre']) ? htmlspecialchars($_POST['nombre']) : '';
$fichero = isset($_POST['fichero']) ? htmlspecialchars($_POST['fichero']) : '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['enviar'])) {

    $longitudNombre = strlen($nombre);

    if ($longitudNombre < 4) {
        $errores['errorNombre'] = "El archivo debe tener un nombre con más de tres caracteres.";
    } elseif ($longitudNombre > 31) {
        $errores['errorNombre'] = "El archivo no debe tener más de treinta caracteres.";
    }

    if (isset($_FILES['fichero'])) {
        $archivoSubido = $_FILES['fichero'];

        if ($archivoSubido['error'] === 0) {
            $tamanyo = $archivoSubido["size"];
            $tipoArchivo = strtolower(pathinfo($archivoSubido['name'], PATHINFO_EXTENSION));

            if ($tamanyo > 100) {
                $errores['errorFichero'] = "El archivo es demasiado grande. Máximo 100 bytes.";
            } elseif ($tipoArchivo !== 'txt') {
                $errores['errorFichero'] = "El archivo debe tener la extensión .txt";
            } else {
                // Procesar contenido si pasa validaciones anteriores
                $contenido = file_get_contents($archivoSubido['tmp_name']);
                $palabras = array_map('trim', explode(",", $contenido));
                sort($palabras);

                if (count($palabras) !== 5) {
                    $errores['errorFichero'] = "El archivo debe tener exactamente 5 palabras separadas por comas.";
                }
            }
        } else {
            $errores['errorFichero'] = "Error al subir el archivo.";
        }
    }

    // Si NO hay errores (es decir, el array está vacío)
    if (count($errores) === 0) {
        $nombreFinal = $nombre . ".txt";
        $destino = "/home/DAW2/Entornoservidor/palabras/" . $nombreFinal;

        if (file_exists($destino)) {
            $errores['errorFichero'] = "El archivo ya existe en la carpeta.";
        } else {
            if (file_put_contents($destino, $contenido) !== false) {
                $mensaje .= "<br>Archivo guardado en: $destino<br>";
                $mensaje .= "Fichero guardado correctamente<br>";
                $mensaje .= "Palabras del fichero:<ul>";

                $manejador = fopen($destino, 'r');
                if ($manejador) {
                    while (!feof($manejador)) {
                        $linea = fgets($manejador);
                        $caracteres = explode(",", $linea);
                        foreach ($caracteres as $caracter) {
                            $mensaje .= "<li>" . htmlspecialchars(trim($caracter)) . "</li>";
                        }
                    }
                    fclose($manejador);
                }

                $mensaje .= "</ul>";
            } else {
                $errores['errorFichero'] = "Hubo un error al guardar el archivo.";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Fichero</title>
    <link rel="stylesheet" href="https://cdn.simplecss.org/simple.min.css">
    <style>
        .error {
            display: block;
            font-size: small;
            color: red;
        }
    </style>
</head>

<body>
    <form action="" method="post" enctype="multipart/form-data">
        <label for="nombre">Nombre del fichero:</label>
        <input type="text" id="nombre" name="nombre" required>
        <small class="error <?php echo empty($errores['errorNombre']) ? 'hidden' : ''; ?>">
            <?php echo $errores['errorNombre']; ?>
        </small>
        <br><br>
        <label for="fichero">Selecciona el fichero:</label>
        <input type="file" id="fichero" name="fichero" required>
        <small class="error <?php echo empty($errores['errorFichero']) ? 'hidden' : ''; ?>">
            <?php echo $errores['errorFichero']; ?>
        </small>
        <br><br>
        <input type="submit" value="Crear fichero" name="enviar">
    </form>

    <?php if (!empty($mensaje)): ?>
        <div style="color: green; font-weight: bold;">
            <?php echo $mensaje; ?>
        </div>
    <?php endif; ?>

</body>

</html>
