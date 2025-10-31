<?php
###### RESUELTO PASANDO UN CAMPO HIDDEN EN EL FORMULARIO CON LOS INDICES ######

const NUM_PREGUNTAS = 3;  // Número de preguntas que tendrá el test

// DECLARACIÓN DE VARIABLES
$mensaje = "";
$preguntas_json = "";
$a_preguntas = $a_respuestas = [];
$fichero_preguntas = "e12_preguntas.json";

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['nuevo'])) {
    // Si se ha pulsado el botón "nuevo", recargamos la página para generar un nuevo test
    header("Location: e12_test_2025.php");
    exit;
}
# ########### recuperación de preguntas ###########
// Comprobamos si existe el archivo de preguntas
if (!file_exists($fichero_preguntas))
    $mensaje = "Error, fichero no existe";
else {
    // Leemos el contenido del archivo de preguntas
    $preguntas_json = file_get_contents($fichero_preguntas);
    if ($preguntas_json) {
        // Convertimos las preguntas de JSON a array asociativo
        $a_preguntas = json_decode($preguntas_json, true);
    } else
        $mensaje = "Error, fichero no existe";
}


// Si el método es POST y se ha pulsado enviar, procesamos las respuestas
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['enviar'])) {
    // Recuperamos las respuestas seleccionadas por el usuario en un array
    for ($i = 0; $i < NUM_PREGUNTAS; $i++) {
        $a_respuestas[] = $_POST["respuesta_" . $i] ?? '';
    }
    //Comparamos las respuestas con las correctas y mostrar el resultado
    $indices = $_POST['indice'] ?? '';
    $indices = explode(",", $indices);// Convertimos la cadena en array
    $acertadas = 0;
    foreach ($indices as $i => $indice) {
        if ($a_respuestas[$i] == $a_preguntas[$indice]['respuesta_correcta']) {
            $acertadas++;
        }
    }
    $mensaje = "Acertadas: $acertadas de " . NUM_PREGUNTAS;

} else {
    // Si no entra por POST, generamos un test de tres preguntas aleatorias
    // Tomamos tres preguntas aleatorias del array de preguntas
    $indice_preguntas = array_rand($a_preguntas, NUM_PREGUNTAS);

    // Creamos un nuevo array solo con las preguntas seleccionadas
    foreach ($indice_preguntas as $indice) {
        $preguntas[] = $a_preguntas[$indice];
    }
    // Convertimos el array de índices en una cadena separada por comas
    $str_indice_preguntas = implode(",", $indice_preguntas);
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
        <h2>Test sobre PHP</h2>
    </header>
    <main>
        <!-- Formulario del test -->
        <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="post">
            <?php
            // Si hay preguntas, mostramos el test
            if (!empty($preguntas)):
                $contador = 0;
                foreach ($preguntas as $pregunta) {
                    echo "<p>";
                    // Mostramos el enunciado de la pregunta
                    echo "<label for='respuesta_$contador'>" . ($contador + 1) . ".- {$pregunta['pregunta']}</label>";
                    // Por cada opción generamos un campo de tipo radio
                    foreach ($pregunta['opciones'] as $opciones) {
                        echo "<input type='radio' name='respuesta_$contador' value='$opciones'>$opciones<br>";
                    }
                    echo "</p>";
                    $contador++;
                } ?>
                <!-- Campo oculto para pasar el identificador único del usuario (si lo usas) -->
                <input type="hidden" name="indice" value="<?= $str_indice_preguntas ?? '' ?>">
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