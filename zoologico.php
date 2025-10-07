<?php
$animales = [    
    ['nombre' => 'Simba', 'especie' => 'León', 'interacciones' => 5],
    ['nombre' => 'Dumbo', 'especie' => 'Elefante', 'interacciones' => 10],
    ['nombre' => 'George', 'especie' => 'Mono', 'interacciones' => 8],
    ['nombre' => 'Flipper', 'especie' => 'Delfín', 'interacciones' => 15],
    ['nombre' => 'Baloo', 'especie' => 'Oso', 'interacciones' => 7],
    ['nombre' => 'Rex', 'especie' => 'Tiranosaurio', 'interacciones' => 20],
    ['nombre' => 'Nemo', 'especie' => 'Pez Payaso', 'interacciones' => 12],
    ['nombre' => 'Spike', 'especie' => 'Erizo', 'interacciones' => 3],
    ['nombre' => 'Luna', 'especie' => 'Lobo', 'interacciones' => 9],
    ['nombre' => 'Coco', 'especie' => 'Loro', 'interacciones' => 11],
    ['nombre' => 'Flash', 'especie' => 'Tortuga', 'interacciones' => 2],
    ['nombre' => 'Thor', 'especie' => 'Águila', 'interacciones' => 14]
];


function  registrar_interaccion(&$animales, $nombre_animal) {
   
$n_animales = count($animales);
// booleano para controlar
$encontrado = false;

 if ($n_animales == 0) {
    echo "El zoologico esta vacio";
    return;
 }
    
foreach ($animales as $indice => $animal) {
    if ($animal['nombre'] === $nombre_animal) {
        $encontrado = true;
      $animales[$indice]['interacciones']++;
        break;
    }

}

 if (!$encontrado) {
      echo "No existe dicho animal.";
    }
}


function animales_mas_interactivos( $animales) {
    $interacciones = array_column($animales, 'interacciones');
    $max_interacciones = max($interacciones);
    $resultado = [];



foreach ($animales as $animal) {
    if ($animal['interacciones'] === $max_interacciones) {
        // forma de agregar el animal al array
        $resultado[] = $animal; 
    }
}
return $resultado;
}


function promedio_interacciones_por_especie($animales) {
// con array unique puedes filtrar las especies unicas (asi no habrá repetidas)
    $especies = array_unique(array_column($animales, 'especie'));
    $promedios = [];
    
    
    foreach ($especies as $especie) {
        // filter para filtrarlo todo
        $animales_especie = array_filter($animales, function($animal) use ($especie) {
            return $animal['especie'] === $especie;
        });
        
        // Paso 3: Calcular suma de interacciones
        $suma_interacciones = array_sum(array_column($animales_especie, 'interacciones'));
        
        // Paso 4: Calcular promedio
        $cantidad_animales = count($animales_especie);
        $promedio = $suma_interacciones / $cantidad_animales;
        
        // Guardar resultado
        $promedios[$especie] = $promedio;
    }
    
    return $promedios;
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php
    
     // PRUEBAS DE LAS FUNCIONES hechas con deepseek
    echo "<div class='resultado'>";
    echo "<h2>🏠 Animales en el Zoológico:</h2>";
    foreach ($animales as $animal) {
        echo "<div class='animal'>{$animal['nombre']} - {$animal['especie']} - {$animal['interacciones']} interacciones</div>";
    }
    echo "</div>";

    // PRUEBA 1: Registrar interacciones
    echo "<div class='resultado'>";
    echo "<h2>🔄 Probando registrar_interaccion:</h2>";
    
    echo "<h3>Interacción con Simba:</h3>";
    registrar_interaccion($animales, 'Simba');
    echo "<p>Interacciones de Simba ahora: " . $animales[0]['interacciones'] . "</p>";
    
    echo "<h3>Interacción con animal que no existe:</h3>";
    registrar_interaccion($animales, 'Pikachu');
    echo "</div>";

    // PRUEBA 2: Animales más interactivos
    echo "<div class='resultado'>";
    echo "<h2>🏆 Animales más interactivos:</h2>";
    $mas_interactivos = animales_mas_interactivos($animales);
    foreach ($mas_interactivos as $animal) {
        echo "<p><strong>{$animal['nombre']}</strong> ({$animal['especie']}) - {$animal['interacciones']} interacciones</p>";
    }
    echo "</div>";

    // PRUEBA 3: Promedios por especie
    echo "<div class='resultado'>";
    echo "<h2>📊 Promedio de interacciones por especie:</h2>";
    $promedios = promedio_interacciones_por_especie($animales);
    foreach ($promedios as $especie => $promedio) {
        echo "<p><strong>{$especie}:</strong> " . number_format($promedio, 2) . " interacciones en promedio</p>";
    }
    echo "</div>";

    // PRUEBA 4: Ver estado actual después de las interacciones
    echo "<div class='resultado'>";
    echo "<h2>📈 Estado actual después de interacciones:</h2>";
    foreach ($animales as $animal) {
        echo "<div class='animal'>{$animal['nombre']} - {$animal['especie']} - {$animal['interacciones']} interacciones</div>";
    }
    echo "</div>";
    
    ?>
    
</body>
</html>