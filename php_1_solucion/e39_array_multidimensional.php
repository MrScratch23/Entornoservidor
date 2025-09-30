<?php
    //código php
    $array_multi = [
        ['indice'=>1, 'nombre'=>"Pepe", 'apellidos'=>'Lluyot'],
        ['indice'=>2, 'nombre'=>"Juan", 'apellidos'=>'Pérez'],
        ['indice'=>3, 'nombre'=>"Ana", 'apellidos'=>'Ruiz'],
        ['indice'=>4, 'nombre'=>"Elena", 'apellidos'=>'Sánchez']
    ];
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
    <header><h2></h2></header>
    <main>
        <!-- código php -->
        <pre>
            <?php print_r ($array_multi); ?>
        </pre>
        <?php
            foreach ($array_multi as $elemento)
            {
                echo "<pre>";
                print_r ($elemento);
                echo "</pre>";
                echo "<hr>";
                /*foreach ($elemento as $indice => $item){
                    echo $item;
                    echo "<br>";

                }*/
                echo $elemento["nombre"]. " " . $elemento["apellidos"]. "<br>";
                
            }
        ?>
        <p class='notice'></p>
    </main>
    <footer><p>P.Lluyot</p></footer>
</body>
</html>