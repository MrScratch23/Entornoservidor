<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php 
    $color = "verde";
    // #COLOR = "azul"; es una variable distinta
    
   echo "<h2> Mi color favorito es $color</h2>";

   // concatenar cadenas con punto

   echo "<h2> Mi color favorito es ".$color."</h2>";

// ponemos comillas simples para ver el comportamiento 

 echo '<h2> Mi color favorito es $color</h2>';
 echo '<h2> Mi color favorito es ".$color."</h2>';
    
    ?>
    
    
</body>
</html>