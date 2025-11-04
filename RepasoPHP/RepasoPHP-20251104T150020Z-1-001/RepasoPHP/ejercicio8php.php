<?php
// =============================================
// CÓDIGO PHP - EJERCICIO 10
// =============================================

$mensaje = "";
$preguntas_mostrar = [];
$respuestas_correctas = [];

// 1. CARGAR PREGUNTAS DESDE ARCHIVO JSON
$json_data = file_get_contents('preguntas.json');
$todas_preguntas = json_decode($json_data, true);

// 2. VER SI ES LA PRIMERA VEZ (mostrar preguntas) O SEGUNDA (corregir)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // PROCESAR RESPUESTAS DEL USUARIO
    $respuestas_correctas = unserialize($_POST['respuestas_correctas']);
    $puntuacion = 0;
    $total_preguntas = count($respuestas_correctas);
    
    for ($i = 0; $i < $total_preguntas; $i++) {
        $respuesta_usuario = $_POST["respuesta_$i"] ?? '';
        if ($respuesta_usuario === $respuestas_correctas[$i]) {
            $puntuacion++;
        }
    }
    
    $mensaje = "🎉 Obtuviste $puntuacion de $total_preguntas respuestas correctas";
    
} else {
    // MOSTRAR PREGUNTAS ALEATORIAS
    $indices_aleatorios = array_rand($todas_preguntas, 3);
    
    foreach ($indices_aleatorios as $indice) {
        $preguntas_mostrar[] = $todas_preguntas[$indice];
        $respuestas_correctas[] = $todas_preguntas[$indice]['respuesta_correcta'];
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Quiz PHP</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 40px; }
        .container { max-width: 600px; margin: 0 auto; }
        .pregunta { background: #f8f9fa; padding: 20px; border-radius: 8px; margin: 15px 0; border-left: 4px solid #007bff; }
        .opciones { margin: 10px 0; }
        .opcion { margin: 8px 0; }
        button { padding: 10px 20px; background: #007bff; color: white; border: none; border-radius: 5px; cursor: pointer; font-size: 16px; }
        button:hover { background: #0056b3; }
        .resultado { background: #e8f5e8; padding: 20px; border-radius: 8px; margin: 20px 0; text-align: center; }
    </style>
</head>
<body>
    <div class="container">
        <h1>📝 Quiz de PHP</h1>
        
        <?php if (empty($preguntas_mostrar) && empty($_POST)): ?>
            <p>No hay preguntas disponibles.</p>
        <?php elseif (!empty($preguntas_mostrar)): ?>
            <form method="POST">
                <?php foreach ($preguntas_mostrar as $index => $pregunta): ?>
                    <div class="pregunta">
                        <h3><?php echo ($index + 1) . '. ' . htmlspecialchars($pregunta['pregunta']); ?></h3>
                        <div class="opciones">
                            <?php foreach ($pregunta['opciones'] as $opcion): ?>
                                <div class="opcion">
                                    <input type="radio" name="respuesta_<?php echo $index; ?>" value="<?php echo htmlspecialchars($opcion); ?>" required>
                                    <label><?php echo htmlspecialchars($opcion); ?></label>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
                
                <input type="hidden" name="respuestas_correctas" value="<?php echo htmlspecialchars(serialize($respuestas_correctas)); ?>">
                <button type="submit">📤 Enviar Respuestas</button>
            </form>
        <?php endif; ?>
        
        <?php if ($mensaje): ?>
            <div class="resultado">
                <h2>Resultado:</h2>
                <?php echo $mensaje; ?>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>