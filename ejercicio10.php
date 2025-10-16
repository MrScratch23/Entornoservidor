<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php

    // con arryasum, si el arrayes numerico, te suma los numeros
    
    $edad_estudiantes = array(18, 56, 12, 67, 14, 43);
    // $numero_estudiantes = array_rum($edad_estudiantes);


    $mayores_edad = 0;
    $numero_estudiantes = count($edad_estudiantes);
    $contador = 0;
    $suma = 0;
    
    // con array filter podemos crear un nuevo array con los mayores de edad filtrados
    // $mayores_edad = array_filter($edad_estudiantes, fn($edad)
    // => $edad > 18);
    
   


     
    do {

        $suma += $edad_estudiantes[$contador];



        if ($edad_estudiantes[$contador] > 18) {
            $mayores_edad++;
        }
        $contador++;
    } while ($contador < $numero_estudiantes);

        $media = $suma / $numero_estudiantes;

    echo '<p> El numero total de estudiantes es: ' . $numero_estudiantes . '</p><br>';
    echo '<p> Y el numero de mayores de edad es: ' . $mayores_edad . '</p><br>';
    echo '<p> La edad media de los estudiantes es de:  ' . $media . '</p>';
    
    ?>
    
</body>
</html>