
<?php
session_start();


if (!isset($_SESSION['usuario'])) {
    header("Location: index.php", true, 302);
}

$usuario = $_SESSION['usuario'];

if (!isset($_SESSION['puntuacion_actual'])) {
    $_SESSION['puntuacion_actual'] = 0;
    $_SESSION['cartas'] = [];
    $_SESSION['juego_terminado'] = false;
    $_SESSION['resultado'] = 'jugando';
}



$cartas = $_SESSION['cartas'];
$puntuacion = $_SESSION['puntuacion_actual'];
$resultado = $_SESSION['resultado'];
$_SESSION['intentos'] = 0;

?>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blackjack - En Juego</title>
    <link rel="stylesheet" href="https://cdn.simplecss.org/simple.min.css">
    <style>
        .carta {
            display: inline-block;
            width: 80px;
            height: 120px;
            border: 2px solid #333;
            border-radius: 8px;
            margin: 5px;
            padding: 10px;
            text-align: center;
            background: white;
            box-shadow: 2px 2px 5px rgba(0,0,0,0.3);
            font-size: 18px;
            font-weight: bold;
        }
        .corazon, .diamante { color: red; }
        .pica, .trebol { color: black; }
        .puntuacion {
            font-size: 24px;
            font-weight: bold;
            margin: 20px 0;
        }
        .mensaje {
            padding: 15px;
            border-radius: 5px;
            margin: 15px 0;
            font-weight: bold;
        }
        .ganador { background: #d4edda; color: #155724; }
        .perdedor { background: #f8d7da; color: #721c24; }
        .info { background: #d1ecf1; color: #0c5460; }
    </style>
</head>
<body>
    <h1>♠️ ♥️ Blackjack Online ♦️ ♣️</h1>
    
    <h2>Jugador: <?php echo htmlspecialchars($usuario); ?></h2>
    
    <div class="mensaje info">
        <p>Límite: 21 puntos - ¡No te pases!</p>
    </div>

    <!-- Cartas del jugador -->
    <h3>Tus Cartas:</h3>
    <div id="cartas-jugador">
       
    <?php foreach ($cartas as $carta): ?>
        <div class="carta"><?php echo $carta; ?></div>
    <?php endforeach; ?>

    </div>

    <!-- Puntuación -->
    <div class="puntuacion">
        Puntuación: <!-- PHP mostrará la puntuación aquí -->
        <?php
        echo $puntuacion;
        ?>
    </div>

    <!-- Mensajes del juego -->
    <div id="mensaje-juego">
        <?php
        echo $resultado;
        ?>
    </div>

    <!-- Controles del juego -->

<div id="controles-juego">
    <form method="post" action="procesar_juego.php" style="display: inline;">
        <input type="hidden" name="accion" value="pedir_carta">
        <button type="submit">Pedir Carta</button>
    </form>
    
    <form method="post" action="procesar_juego.php" style="display: inline;">
        <input type="hidden" name="accion" value="plantarse">
        <button type="submit">Plantarse</button>
    </form>
</div>

    <br>
    <a href="cerrar_sesion.php">Volver al Login</a>
</body>
</html>