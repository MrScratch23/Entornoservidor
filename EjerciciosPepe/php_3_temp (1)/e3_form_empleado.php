<?php
$mensaje = "";
$nombre = "";
$apellidos = "";

// Verificamos si el formulario ha sido enviado
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["enviar"])) {

    // 1) Recogida y saneado de datos
    $nombre = htmlspecialchars(trim($_GET["nombre"] ?? ""));
    $apellidos = htmlspecialchars(trim($_GET["apellidos"] ?? ""));

    // 2) validación de datos
    //Verificamos si los campos están llenos
    if ($nombre === "" || $apellidos === "") {
        $mensaje .= "Por favor, rellena todos los campos.";
    }else {
        //verificamos que el nombre tenga una longitud de <25
        if (strlen($nombre) > 25) {
            $mensaje .=  "El nombre no debe tener más de 25 caracteres.";
        }//verificamos que los apellidos tengan una longitud de <35
        if (strlen($apellidos) > 35) {
            $mensaje .=  "Los apellidos no deben tener más de 35 caracteres.";
        }
    }
    // 3) Si no hay errores generamos el mensaje
    if (empty($errores)) {
        $mensaje =  "Formulario enviado correctamente.<br>
                    <strong>Nombre:</strong> $nombre<br>
                    <strong>Apellidos:</strong> $apellidos";
    }

}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <!-- <link rel="stylesheet" href="https://cdn.simplecss.org/simple.min.css"> -->
    <link rel="stylesheet" href="https://cdn.simplecss.org/simple.css">


</head>

<body>
    <header>
        <h2>Formulario empleado</h2>
    </header>
    <main>
        <!--ejemplo de formulario con get -->
        <form action="" method="get">
            <p>
                <label for="nombre">Nombre:</label>
                <input type="text" name="nombre" id="nombre" size="20" placeholder="<<Nombre del empleado>>" required value="<?= $nombre; ?>">
                <label for="apellidos">Apellidos:</label>
                <input type="text" name="apellidos" id="apellidos" size="40" placeholder="<<Apellidos del empleado>>" required value="<?= $apellidos; ?>">
            </p>
            <input type="submit" name="enviar" value="Enviar">
        </form>
        <?php
        echo !empty($mensaje) ? "<p class='notice'>" . $mensaje . "</p>" : "";
        ?>
    </main>
    <footer>P.Lluyot-24</footer>
</body>

</html>