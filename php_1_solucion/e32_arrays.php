<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP</title>
</head>

<body>

    <?php
    $paises = array("España", "Francia", "Italia");
    foreach ($paises as $pais) {
        echo $pais . "<br>";
    }

    $personas = [
        "nombre" => "Pepe",
        "edad" =>   52, 
        "ciudad" => "Alcalá de Guadaira"
    ];
    foreach ($personas as $clave => $valor) {
        echo "Clave: $clave  -  Valor: $valor <br>";
    }
    ?>
</body>

</html>