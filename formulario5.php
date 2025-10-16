<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $color = htmlspecialchars( $_POST['colorfondo']) ?? '';
    $fuente = htmlspecialchars( $_POST['fuentetexto']) ?? '';
    $tipotexto = htmlspecialchars( $_POST['tipotexto']) ?? '';
    $frases = [
    "narrativas" => [
        "El viento susurraba entre las hojas, contando historias de tiempos olvidados.",
        "Ella caminaba por la ciudad, buscando un lugar donde el tiempo pareciera detenerse.",
        "La casa abandonada guardaba secretos que nadie se atrevía a descubrir."
    ],
    "poeticas" => [
        "Tus ojos son dos luceros que iluminan mis noches más oscuras.",
        "El río canta su melodía, acariciando las piedras con ternura infinita.",
        "En el silencio de la madrugada, las estrellas dibujan versos en el cielo."
    ],
    "ensayo" => [
        "La importancia de la educación radica en su capacidad para transformar sociedades y abrir puertas hacia el progreso.",
        "El cambio climático representa uno de los mayores retos de nuestra era, exigiendo acción urgente y colectiva.",
        "La lectura crítica es fundamental para el desarrollo del pensamiento autónomo y la formación de ciudadanos informados."
    ]
];


  

    $mensaje = "";

switch ($tipotexto) {
    case 'Narrativo':
        $n_indice = array_rand($frases['narrativas']);
        $mensaje = $frases['narrativas'][$n_indice];
        break;
    case 'Poético':
        $n_indice = array_rand($frases['poeticas']);
        $mensaje = $frases['poeticas'][$n_indice];
        break;
    case 'Ensayo':
        $n_indice = array_rand($frases['ensayo']);
        $mensaje = $frases['ensayo'][$n_indice];
        break;
}




    
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Generación de textos</title>
    <link rel="stylesheet" href="https://cdn.simplecss.org/simple.min.css" />
</head>

<body>
    <h1>Generación de textos:</h1>

    <form method="POST" action="">
        <label for="colorfondo">Elige un color de fondo</label>
        <select name="colorfondo" id="colorfondo">
            <option value="#00FF00">Verde</option>
            <option value="#0000FF">Azul</option>
            <option value="#FF0000">Rojo</option>
        </select>

        <label for="fuentetexto">Elige la fuente del texto:</label>
        <select name="fuentetexto" id="fuentetexto">
            <option value="Arial">Arial</option>
            <option value="Verdana">Verdana</option>
            <option value="Courier">Courier</option>
        </select>

        <label for="tipotexto">Elige el tipo de texto:</label>
        <select name="tipotexto" id="tipotexto">
            <option value="Narrativo">Narrativo </option>
            <option value="Poético">Poético </option>
            <option value="Ensayo">Ensayo </option>
        </select>

        <input type="submit" value="Cambiar" />
    </form>
    <?php
    
   echo "<p class='notice' style='background-color:$color;font-family:$fuente'>$mensaje</p>";

    
    ?>

</body>

</html>
