<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php
    $fruta = "Platano";
   switch ($fruta) {
    case 'Platano':
        echo "El color es amarillo";
        break;
    case 'Manzana':
        echo "El color es rojo";
    
    default:
        echo "Color no disponible";
        break;
   }
    
    
    ?>
    
</body>
</html>