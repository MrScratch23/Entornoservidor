<?php
$fichero = [];
$mensaje = "";
$errores = [];


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['enviar'])) {


    if (isset($_FILES['fichero_imagen'])) {
        $fichero = $_FILES['fichero_imagen'];


        if ($fichero['error'] == 0) {
            $mensaje .= "Fichero subido correctamente";

            $tamaño = $_FILES['fichero_imagen']["size"];
            $tipoArchivo = strtolower(pathinfo($fichero['name'], PATHINFO_EXTENSION));


            if ($tamaño / (1024 * 1024) >  1) {
                $errores[] = "El archivo no puede pesar más de 1MB.";
            }

            if ($tipoArchivo != "jpeg" && $tipoArchivo != "jpg" && $tipoArchivo != "png") {
                $errores[] = "Tipo de archivo subido incorrecto";
            }


        } else {
            $errores[] = "Error al subir el fichero.";
        }


        if (empty($errores)) {
            $destino = "/home/DAW2/Entornoservidor/tmparchivos/" . basename($fichero['name']);
            if (move_uploaded_file($fichero['tmp_name'], $destino)) {
                $mensaje .= "<br>Archivo guardado en: $destino<br>";

                $mensaje .= "<img src='$destino' alt='Imagen subida' style='max-width:300px;'><br>";
            } else {
                $errores[] = "No se pudo mover el archivo subido.";
            }
        }
    };
}








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


    <h1> Subida de archivos</h1>


    <form action="ejercicioarchivos1.php" method="post" enctype="multipart/form-data">
        <p>
            <input type="file" name="fichero_imagen" id="fichero_imagen">
            <br>
            <br>
            <input type="submit" name="enviar" value="enviar">


        </p>


    </form>

    <?php
    if (!empty($errores)) {
        foreach ($errores as $error) {
            echo "<p style='color:red;'>$error</p>";
        }
    }

    if (!empty($mensaje)) {
        echo "<p>$mensaje</p>";
    }
    ?>

</body>

</html>