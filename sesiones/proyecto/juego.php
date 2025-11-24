
<?php
// JUEGO.PHP
session_start();

// 1. INICIAR SESIÓN Y VERIFICAR USUARIO
//    - Si NO existe $_SESSION['usuario'], redirigir a index.php
if (!isset($_SESSION['usuario'])) {
    header("Location: index.php", true, 302);
    exit();
}

$usuario = $_SESSION['usuario'];

// 2. CARGAR PREGUNTAS DESDE ARCHIVO
//    - Leer "data/preguntas.txt"
//    - Convertir cada línea en array con explode('|', $linea)
//    - Crear array de preguntas con estructura:
//      [
//        'id' => ...,
//        'pregunta' => ...,
//        'opcion_a' => ...,
//        'opcion_b' => ...,
//        'opcion_c' => ...,
//        'respuesta_correcta' => ...
//      ]



$archivo = "data/preguntas.txt";
$lineas = file($archivo, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

foreach ($lineas as $linea) {
    // Procesar cada línea con explode('|', $linea)
    $datos = explode('|', $linea);
    $preguntas[] = [
       "id" => $datos[0],
       "pregunta" => $datos[1],
        "respuesta_a" => $datos[2],
        "respuesta_b" => $datos[3],
        "respuesta_c" => $datos[4],
        "respuesta_correcta" => $datos[5]
    ];
}




// 3. PROCESAR RESPUESTA (SI SE ENVIÓ)
//    - Si existe $_POST['respuesta'] y $_POST['pregunta_id']:
//      a) Buscar la pregunta por ID en el array de preguntas
//      b) Comparar respuesta_usuario con respuesta_correcta
//      c) Si es correcta: sumar aciertos y puntos (+10)
//      d) Si es incorrecta: sumar fallos
//      e) Agregar pregunta_id a $_SESSION['preguntas_respondidas']
//      f) Incrementar $_SESSION['turno']
//      g) Guardar mensaje de resultado en $_SESSION['mensaje']




$mensaje = $_SESSION['mensaje'] ?? '';


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['respuesta']) && isset($_POST['pregunta_id'])) {
    $respuesta_usuario = htmlspecialchars(trim($_POST['respuesta']));
    $pregunta_id = $_POST['pregunta_id'];
    
    // Buscar la pregunta correcta
    $pregunta_correcta = null;
    foreach ($preguntas as $preg) {
        if ($preg['id'] == $pregunta_id) {
            $pregunta_correcta = $preg;
            break;
        }
    }
    
    if ($pregunta_correcta) {
        if ($respuesta_usuario === $pregunta_correcta['respuesta_correcta']) {
            // Respuesta correcta
            $_SESSION['puntos'] += 10;
            $_SESSION['aciertos']++;
            $_SESSION['mensaje'] = "¡Correcto! +10 puntos";
        } else {
            // Respuesta incorrecta
            $_SESSION['fallos']++;
            $_SESSION['mensaje'] = "Incorrecto. La respuesta correcta era: " . $pregunta_correcta['respuesta_correcta'];
        }
        
        // Agregar a preguntas respondidas y aumentar turno
        $_SESSION['preguntas_respondidas'][] = $pregunta_id;
        $_SESSION['turno']++;
        
        // Recargar la página para mostrar nueva pregunta
        header("Location: juego.php");
        exit();
    }
}






// 4. OBTENER PREGUNTA ACTUAL
// Filtrar preguntas no respondidas
$preguntas_disponibles = array();
foreach ($preguntas as $pregunta) {
    if (!in_array($pregunta['id'], $_SESSION['preguntas_respondidas'])) {
        $preguntas_disponibles[] = $pregunta;
    }
}

// Si hay preguntas disponibles, elegir una al azar
if (!empty($preguntas_disponibles)) {
    $indice = array_rand($preguntas_disponibles, 1);
    $pregunta_actual = $preguntas_disponibles[$indice];
    $juego_terminado = false;
} else {
    // Si no hay preguntas, marcar $juego_terminado = true
    $pregunta_actual = null;
    $juego_terminado = true;
}

// 5. MOSTRAR HTML
//    - Mostrar datos de sesión (usuario, puntos, turno, etc.)
//    - Si hay $_SESSION['mensaje'], mostrarlo y luego limpiarlo
//    - Si $juego_terminado es true, mostrar pantalla de fin
//    - Si no, mostrar la pregunta actual con opciones de respuesta
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
        <h1>Juego de Preguntas</h1>
        
        <div class="user-info">
            <p>Jugador: <strong><?php
            echo $usuario
            ?></strong></p>
            <p>Turno: <span id="turno"><?php
            echo $_SESSION['turno'];
            ?></span> | Puntos: <span id="puntos">
                <?php
                echo $_SESSION['puntos'];
                ?>
            </span></p>
            <p>Aciertos: <span id="aciertos"><?php echo $_SESSION['aciertos']?></span> | Fallos: <span id="fallos"><?php echo $_SESSION['fallos'] ?></span></p>
        </div>
        
        <div class="mensaje">
        <?php
        echo $mensaje;
        unset($_SESSION['mensaje']);
        ?>


        </div>
        
       <?php if (!$juego_terminado && isset($pregunta_actual)): ?>
    <div class="pregunta">
        <h3>Pregunta #<?php echo $_SESSION['turno']; ?></h3>
        <p id="texto-pregunta"><?php echo htmlspecialchars($pregunta_actual['pregunta']); ?></p>
        
        <form action="juego.php" method="post">
            <input type="hidden" name="pregunta_id" value="<?php echo $pregunta_actual['id']; ?>">
            
            <label>
                <input type="radio" name="respuesta" value="A" required>
                <?php echo htmlspecialchars($pregunta_actual['respuesta_a']); ?>
            </label><br>
            
            <label>
                <input type="radio" name="respuesta" value="B">
                <?php echo htmlspecialchars($pregunta_actual['respuesta_b']); ?>
            </label><br>
            
            <label>
                <input type="radio" name="respuesta" value="C">
                <?php echo htmlspecialchars($pregunta_actual['respuesta_c']); ?>
            </label><br>
            
            <button type="submit">Responder</button>
        </form>
    </div>
<?php else: ?>
    <div class="fin-juego">
        <h2>¡Juego Terminado!</h2>
        <p>Has respondido todas las preguntas.</p>
        <p>Puntuación final: <strong><?php echo $_SESSION['puntos']; ?> puntos</strong></p>
        <a href="cerrar_sesion.php">Jugar de nuevo</a>
    </div>
<?php endif; ?>
</body>
</html>