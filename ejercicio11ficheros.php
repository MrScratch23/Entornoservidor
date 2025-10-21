<?php

$mensaje = "";
$errores = array(
    "errorNombre" => "",
    "errorFichero" => "",
);

// validaciones de los datos

$nombre = isset($_POST['nombre']) ? htmlspecialchars($_POST['nombre']) : '';
$fichero = isset($_POST['fichero']) ? htmlspecialchars($_POST['fichero']) : '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['enviar'])) {

    $palabrasNombre = strlen($nombre);

    if ($palabrasNombre < 4) {
        $errores['errorNombre'] = "El archivo debe tener un nombre con mas de tres caracteres";
    } elseif ($palabrasNombre > 31) {
        $errores['errorNombre'] = "El archivo no debe tener mas de treinta caracteres.";
    }

    if (isset($_FILES['fichero'])) {
        $fichero = $_FILES['fichero'];
        if ($fichero['error'] == 0) {

            $tamanyo = $_FILES['fichero']["size"];
            $tipoArchivo = strtolower(pathinfo($fichero['name'], PATHINFO_EXTENSION));

            if ($tamanyo > 100) {
                $errores['errorFichero'] = "El archivo es demasiado grande. Maximo 100 bytes.";
            }
            if ($tipoArchivo !== 'txt') {
                $errores['errorFichero'] = "El archivo debe contener la extension .txt";
            }

            // verificar las palabras del archivo
            $manejador = @fopen($fichero['tmp_name'], 'r');
            $contenidoArchivo = '';
            if ($manejador) {
                $contenidoArchivo = fread($manejador, filesize($fichero['tmp_name']));
                fclose($manejador);

                // Dividir en caracteres para contar
                $elementos = str_split($contenidoArchivo);

                if (count($elementos) <= 5) {
                    $errores['errorFichero'] = "El texto debe tener más de 5 caracteres.";
                }
            }

            if (empty($errores)) {
                $nombreFinal = $nombre . ".txt";
                $destino = "/home/DAW2/Entornoservidor/palabras/" . $nombreFinal;

                if (file_exists($destino)) {
                    $errores['errorFichero'] = "El archivo ya existe en la carpeta.";
                } else {
                    // Leer el contenido original
                    $contenidoOriginal = file_get_contents($fichero['tmp_name']);

                    // Dividir cada carácter y unirlo con comas
                    $contenidoProcesado = implode(',', str_split($contenidoOriginal));

                    // Guardar el nuevo contenido con caracteres separados por comas
                    if (file_put_contents($destino, $contenidoProcesado) !== false) {
                        $mensaje .= "<br>Archivo guardado en: $destino<br>";
                        $mensaje .= "Fichero guardado correctamente<br>";
                        $mensaje .= "Caracteres del fichero:<ul>";

                        // Mostrar el contenido caracter por caracter
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
