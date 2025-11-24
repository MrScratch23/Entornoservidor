<?php
session_start();

$html = "";

if (file_exists("data/usuarios.txt")) {
    $lineas = file("data/usuarios.txt", FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    
    if ($lineas) {
        // Obtener las últimas 3 líneas
        $ultimas_lineas = array_slice($lineas, -3);
        $ultimas_lineas = array_reverse($ultimas_lineas); // Para mostrar las más recientes primero
        
        $html = "<h3>Últimos jugadores:</h3><ul>";
        foreach ($ultimas_lineas as $linea) {
            $html .= "<li>" . htmlspecialchars($linea) . "</li>";
        }
        $html .= "</ul>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Juego de Preguntas</title>
    <link rel='stylesheet' href='css/estilos.css'>
</head>
<body>
    <div class="container">
        <h1>Bienvenido al Juego de Preguntas</h1>
        <form action="procesar_login.php" method="post">
            <label>Tu nombre:</label>
            <input type="text" name="nombre" placeholder="Ingresa tu nombre">
            <button type="submit">Comenzar Juego</button>
        </form>
        
        <div class="error">
           <?php if (isset($_SESSION['error'])): ?>
               <br><span style="color: red;"><?php echo $_SESSION['error']; ?></span>
           <?php endif; ?>
        </div>
        
        <div class="stats">
            <?php echo $html; ?>
        </div>
    </div>
</body>
</html>