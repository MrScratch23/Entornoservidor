<?php

/**
 * Ejercicio realizado por P.Lluyot. 2DAW
 */
# DECLARACION DE VARIABLES
$animales = [
    ['nombre' => 'Simba', 'especie' => 'León', 'interacciones' => 4],
    ['nombre' => 'Dumbo', 'especie' => 'Elefante', 'interacciones' => 10],
    ['nombre' => 'George', 'especie' => 'Mono', 'interacciones' => 8],
    ['nombre' => 'Nala', 'especie' => 'León', 'interacciones' => 10],
    ['nombre' => 'Baloo', 'especie' => 'Oso', 'interacciones' => 7],
    ['nombre' => 'Akela', 'especie' => 'Lobo', 'interacciones' => 6],
    ['nombre' => 'Kaa', 'especie' => 'Cocodrilo', 'interacciones' => 9],
    ['nombre' => 'Rex', 'especie' => 'Elefante', 'interacciones' => 10],
    ['nombre' => 'Scar', 'especie' => 'León', 'interacciones' => 4],
    ['nombre' => 'Shere Khan', 'especie' => 'Oso', 'interacciones' => 8],
    ['nombre' => 'Rafiki', 'especie' => 'Mono', 'interacciones' => 9],
    ['nombre' => 'Timon', 'especie' => 'Mono', 'interacciones' => 6],
    ['nombre' => 'Pumba', 'especie' => 'Elefante', 'interacciones' => 10],
    ['nombre' => 'Bagheera', 'especie' => 'Lobo', 'interacciones' => 5],
    ['nombre' => 'Sebastián', 'especie' => 'Cocodrilo', 'interacciones' => 6],
    ['nombre' => 'Mufasa', 'especie' => 'León', 'interacciones' => 8],
    ['nombre' => 'Balto', 'especie' => 'Lobo', 'interacciones' => 7],
    ['nombre' => 'Louie', 'especie' => 'Oso', 'interacciones' => 5]
];

# FUNCIONES
/**
 * Registra una interacción con un animal ( aumenta en 1 la interacción)
 * @param array &$animales Array de animales (por referencia)
 * @param string $nombre_animal Nombre del animal
 * @return string mensaje de texto con el resultado
 */
function registrar_interaccion(&$animales, $nombre_animal)
{
    $mensaje = "";
    //buscamos el nombre del animal en el array
    // usamos un valor por referencia del animal para actualizar el array de animales.
    if (empty($animales)) {
        $mensaje = "<p>❌ Error: No hay animales en el zoológico.</p>";
        return $mensaje;
    }
    //tomamos solo los nombres de los animales en un array
    $nombres = array_column($animales, 'nombre');
    //buscamos el animal
    $indice = array_search($nombre_animal, $nombres);
    if ($indice !== false) {
        $numAntes = $animales[$indice]['interacciones'];
        $animales[$indice]['interacciones']++;
        $numDespues = $animales[$indice]['interacciones'];
        $mensaje .= "<p>Se aumenta la interacción de $nombre_animal (de $numAntes a $numDespues) ";
    } else
        $mensaje .= "<p>❌ Error al registrar interacción: No se encontró el animal '$nombre_animal' </p>";
    return $mensaje;
}
/**
 * Muestra en pantalla un array de forma preformateada (<pre>).
 * @param array $miarray Array a mostrar.
 * @return void
 */
function pintar_array($miarray)
{
    echo "<pre>";
    print_r($miarray);
    echo "</pre>";
}
/**
 * Devuelve los animales más interactivos del zoológico.
 * @param array $animales  Array de animales con sus interacciones.
 * @return string  Cadena con los nombres de los animales más interactivos.
 */
function animales_mas_interactivos($animales)
{
    if (empty($animales)) {
        return "❌ Error animal más interactivo: No hay animales registrados en el zoológico.<br>";
    }
    $arr_interacciones = array_column($animales, 'interacciones');
    $max_interacciones = max($arr_interacciones);
    $animales_interactivos = array_filter($animales, function ($animal) use ($max_interacciones) {
        return $animal['interacciones'] == $max_interacciones;
    });
    /*$animales_interactivos = array_column($animales_interactivos,"nombre");
    $nombre_animales_interactivos = implode(", ",$animales_interactivos);*/

    //para reindexar el array se usa array_values()
    $animales_interactivos = array_values($animales_interactivos);
    return implode(", ", array_column($animales_interactivos, 'nombre'));
}

/**
 * Calcula el promedio de interacciones por especie.
 * @param array $animales  Array de animales con sus especies e interacciones.
 * @return array  Array asociativo con especies como claves y promedio de interacciones como valores.
 */
function  promedio_interacciones_por_especie($animales)
{
    if (empty($animales)) {
        return "Error promedio: No hay animales registrados en el zoológico.<br>";
    }

    $especies = [];
    $num_especies = [];

    foreach ($animales as $animal) {
        $especies[$animal['especie']][] = $animal['interacciones']; //meto en el índice de la especie todas las interacciones posibles
    }
    $promedio_por_especie = [];
    foreach ($especies as $especie => $interaciones) {
        $promedio_por_especie[$especie] = round(array_sum($interaciones) / count($interaciones), 2);
    }

    return $promedio_por_especie;
}

?>

<link rel='stylesheet' href='https://cdn.simplecss.org/simple.min.css'>
</head>

<body>
    <header>
        <h2>Zoológico</h2>
    </header>
    <main>
        <!-- contenido del array -->
        <details name="array">
            <summary>Array</summary>
            <?= pintar_array($animales); ?>
        </details>

        <!-- ejemplo de registro de interacciones  -->
        <h4>Registrar interacciones</h4>
        <?php
            echo registrar_interaccion($animales, 'Akela');
            echo registrar_interaccion($animales, 'Dumbo');
            echo registrar_interaccion($animales, 'noexiste');
        ?>

        <!-- búsquedas de los animales más interactivos -->
        <h4>Animales más interactivos</h4>
        <?php
            echo animales_mas_interactivos($animales)."<br>";
        ?>

        <!-- Promedio de interacciónes por especie -->
        <br>
        <details name="media">
            <summary>Promedio de interacciónes por especie</summary>
            <?php
                $int_media = promedio_interacciones_por_especie($animales);
            ?>
            <?= pintar_array($int_media); ?>
        </details>
     
        <!-- <p class='notice'></p> -->
    </main>
    <footer>
        <p>P.Lluyot</p>
    </footer>
</body>

</html>