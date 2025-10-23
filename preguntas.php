<?php

const N_PREGUNTAS = 3;

if (file_exists("preguntas.json")) {
    // cargar las preguntas desde el archivo JSON
    // leemos para transformarlo en un string con el fgtc
    $archivojson = file_get_contents('preguntas.json');

    // usando DECODE
    $preguntas = json_decode($archivojson, true);

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['enviar'])) {
        // procesamiento de respuestas 
        $aciertos = 0;

        $datos_serializados = file_get_contents("respuestas_temp.txt");
        $respuestas_correctas = unserialize($datos_serializados);

        foreach ($respuestas_correctas as $indice => $respuesta_correcta) {
            $respuesta_usuario = $_POST["pregunta_$indice"];
            if ($respuesta_usuario === $respuesta_correcta) {
                $aciertos++;
            }
        }

        echo "<h2 class='notice'>Resultados: $aciertos/" . N_PREGUNTAS . " aciertos</h2>";
        unlink("respuestas_temp.txt");
    } elseif ($_SERVER['REQUEST_METHOD'] === 'GET') {
        // preparar los datos
        $indices_aleatorios = array_rand($preguntas, N_PREGUNTAS);
        $preguntas_seleccionadas = [];

        foreach ($indices_aleatorios as $indice) {
            $preguntas_seleccionadas[] = $preguntas[$indice];
        }

        $respuestas_correctas = [
            "0" => $preguntas_seleccionadas[0]["respuesta_correcta"],
            "1" => $preguntas_seleccionadas[1]["respuesta_correcta"],
            "2" => $preguntas_seleccionadas[2]["respuesta_correcta"]
        ];

        $datos_serializados = serialize($respuestas_correctas);
        // scribe datos en un archivo (crea o sobreescribe) 
        file_put_contents("respuestas_temp.txt", $datos_serializados);
    }
} else {
    echo "Error: el archivo no existe.";
}


?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cuestionario Aleatorio</title>
    <link rel="stylesheet" href="https://cdn.simplecss.org/simple.min.css">
</head>

<body>
    <?php if (isset($preguntas_seleccionadas)): ?>
        <h1>Cuestionario de Preguntas Aleatorias</h1>
        <form action="" method="POST">
            <?php foreach ($preguntas_seleccionadas as $index => $pregunta): ?>
                <div class="pregunta">
                    <h3>Pregunta <?php echo $index + 1; ?>: <?php echo htmlspecialchars($pregunta['pregunta']); ?></h3>

                    <div class="opciones">
                        <?php foreach ($pregunta['opciones'] as $opcion): ?>
                            <label>
                                <input type="radio" name="pregunta_<?php echo $index; ?>" value="<?php echo htmlspecialchars($opcion); ?>" required>
                                <?php echo htmlspecialchars($opcion); ?>
                            </label><br>
                        <?php endforeach; ?>
                    </div>
                </div>
                <hr>
            <?php endforeach; ?>

            <button type="submit" name="enviar">Enviar Respuestas</button>
        </form>
    <?php endif; ?>
</body>

</html>