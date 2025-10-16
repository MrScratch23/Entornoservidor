<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Día de la Semana</title>
</head>
<body>
    <?php
    
    if (isset($_GET['dia'])) {
        echo "<p>Viene el día</p>";
        $dia = (int)$_GET['dia'];
    } else {
        $dia = rand(1, 7);
    }


    switch ($dia) {
        case 1:
            echo "<p>Hoy es lunes</p>";
            break;
        case 2:
            echo "<p>Hoy es martes</p>";
            break;
        case 3:
            echo "<p>Hoy es miércoles</p>";
            break;
        case 4:
            echo "<p>Hoy es jueves</p>";
            break;
        case 5:
            echo "<p>Hoy es viernes</p>";
            break;
        case 6:
            echo "<p>Hoy es sábado</p>";
            break;
        case 7:
            echo "<p>Hoy es domingo</p>";
            break;
        default:
            echo "<p>Día inválido</p>";
            break;
    }

    // Mostrar cuántos días faltan hasta el domingo
    echo '<p>' . ($dia == 7 ? 'Quedan 7 días hasta el domingo' : 'Quedan ' . (7 - $dia) . ' días hasta el domingo') . '</p>';
    ?>
</body>
</html>
