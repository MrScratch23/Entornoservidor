<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP</title>
</head>

<body>
    <?php
    $frutas = ["manzana", "pera", "naranja"];
    $frutas = array("manzana", "pera", "naranja");
    $frutas = [
        0 => "manzana",
        1 => "pera",
        2 => "naranja"
    ];
    $frutas []= "plátano";  // Añadir un nuevo elemento
    echo implode(", ", $frutas);  // Muestra "manzana, pera, naranja, plátano"
    
    //ejemplo de funciómn explode / implode / count
    $mitexto = "Hola me llamo Pepe";
    $miarray = explode(" ",$mitexto );
    echo "<pre>";
        print_r($miarray);
    echo "</pre>";

    echo "El número de elementos del array es: ". count($miarray);
    ?>
</body>
</html>