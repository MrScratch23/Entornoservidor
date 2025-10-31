<?php
###### RESUELTO USANDO UN FICHERO TEMPORAL PARA GUARDAR LAS SOLUCIONES ######

// Fichero que contiene las preguntas en formato JSON
const FICHERO = 'e12_preguntas.json';
const NUM_PREGUNTAS = 3; 

// Inicializamos las variables
$mensaje = "";
$todas_preguntas = [];
$indices = [];
$soluciones = [];
$archivo_solucion = "";
$uid = "";
$respuestas = [];
$acertadas = 0;

// Comprobamos si se ha enviado el formulario con el botón "enviar"
if ($_SERVER['REQUEST_METHOD'] === "POST" && isset($_POST['enviar'])) {
    // Recuperar las respuestas de cada pregunta del formulario
    for ($i = 0; $i < NUM_PREGUNTAS; $i++) {
        $respuestas[$i] = htmlspecialchars($_POST["respuesta_$i"] ?? '');
    }
    $uid = $_POST['uid'] ?? '';

    // Recuperar las soluciones correctas del archivo temporal usando el uid
    $archivo_solucion = file_get_contents("tmp/solucion_$uid");
    if (!$archivo_solucion) {
        $mensaje = "Error al recuperar las soluciones";
    } else {
        // Convertimos la cadena de soluciones en un array
        $soluciones = explode(",", $archivo_solucion);

        // Comparamos las respuestas del usuario con las soluciones correctas
        if (!empty($soluciones)) {
            foreach ($soluciones as $indice => $solucion) {
                if ($solucion == $respuestas[$indice]) $acertadas++;
            }
        }
        $mensaje = "Acertadas: $acertadas";

        // Eliminamos el archivo temporal de soluciones
        unlink("tmp/solucion_$uid");
    }
    // Si se ha pulsado el botón "nuevo", recargamos la página para generar un nuevo test
} elseif ($_SERVER['REQUEST_METHOD'] === "POST" && isset($_POST['nuevo'])) {
    //recargamos la página (entraría en la parte de generación de preguntas)
    header("Location: e12_test_uid.php");
    exit;

    // Si es la primera vez que se entra, generamos el test
} else {
    // Abrimos el fichero de preguntas y cargamos su contenido
    $contenido = @file_get_contents(FICHERO);
    if ($contenido) {
        // Transformamos el contenido JSON en un array asociativo
        $todas_preguntas = json_decode($contenido, true);

        // Elegimos 3 preguntas aleatorias
        $indices = array_rand($todas_preguntas, 3);

        // Guardamos las respuestas correctas de las preguntas seleccionadas
        foreach ($indices as $indice) {
            $soluciones[] = $todas_preguntas[$indice]['respuesta_correcta'];
        }

        // Generamos un identificador único para el usuario y guardamos las soluciones en un archivo temporal
        $uid = uniqid();
        $archivo_solucion = "tmp/solucion_$uid";
        $tmp_solucion = implode(",", $soluciones); // Cadena con las soluciones separadas por comas
        if (!file_put_contents($archivo_solucion, $tmp_solucion)) // Devuelve el número de bytes escritos o false
            $mensaje = "Error en proceso de guardado";
    } else
        $mensaje = "Error al recuperar el fichero";
}

?>
<!DOCTYPE html>
<html lang='es'>

<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>P.Lluyot</title>
    <link rel='stylesheet' href='https://cdn.simplecss.org/simple.min.css'>
</head>

<body>
    <header>
        <h2>Test de PHP</h2>
    </header>
    <main>
        <form action="e12_test_uid.php" method="post">
            <?php
            // Si hay preguntas seleccionadas, mostramos el test
            if (!empty($indices)):
                $contador = 0;
                foreach ($indices as $indice) {
                    echo "<p>";
                    echo "<label for='respuesta_$contador'>" . ($contador + 1) . ".- {$todas_preguntas[$indice]['pregunta']}</label>";
                    // Por cada opción generamos un campo de tipo radio
                    foreach ($todas_preguntas[$indice]['opciones'] as $opciones) {
                        echo "<input type='radio' name='respuesta_$contador' value='$opciones'>$opciones<br>";
                    }
                    echo "</p>";
                    $contador++;
                } ?>
                <!-- Campo oculto para pasar el identificador único del usuario -->
                <input type="hidden" name="uid" value="<?= $uid; ?>">
                <input type="submit" value="enviar" name="enviar">
            <?php
            // Si no hay preguntas, mostramos el botón para generar un nuevo test
            else: ?>
                <input type="submit" value="nuevo" name="nuevo">
            <?php
            endif;
            ?>
        </form>
        <!-- Mostramos el mensaje de resultado si existe -->
        <?php if (!empty($mensaje)) echo "<p class='notice'>$mensaje</p>"; ?>
    </main>
    <footer>
        <p>P.Lluyot</p>
    </footer>
</body>