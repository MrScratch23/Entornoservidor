<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP</title>
</head>

<body>
    <p><?php
    $frutas = [
        0=>'manzana',
        1=>'peras',
        2=>'sandías'
    ];
    $frutas = array('manzanas', 'peras', 'sandías');
    $frutas = ['manzanas', 'peras', 'sandías'];
    
    //arrays asociativos

    $personas = [
        "nombre" => "Pepe",
        "edad" =>   52, 
        "ciudad" => "Alcalá de Guadaira"
    ];
    $personas = array("nombre" => "Pepe", "edad" =>   56,"ciudad" => "Alcalá de Guadaira");
    //mostramos el valor del elemento ciudad (clave) del array personas.
    echo $personas["ciudad"]."<br>";
    //no podemos el índice 1 en el array asociativo, pues no existe.
    echo $personas[1];
    ?></p>
</body>
</html>