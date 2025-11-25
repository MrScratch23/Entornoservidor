<?php
session_start();

// Verificar que el usuario completó la encuesta
if (!isset($_SESSION['usuario']) || !isset($_SESSION['respuesta1']) || !isset($_SESSION['respuesta2']) || !isset($_SESSION['respuesta3'])) {
    header("Location: index.php", true, 302);
    exit();
}

// Recuperar datos de la sesión
$usuario = $_SESSION['usuario'];
$respuesta1 = $_SESSION['respuesta1'];
$respuesta2 = $_SESSION['respuesta2'];
$respuesta3 = $_SESSION['respuesta3'];

// Respuestas correctas
$correcta1 = 'php';
$correcta2 = 'web';
$correcta3 = 'intermedio';

// Calcular puntaje
$puntaje = 0;
if ($respuesta1 === $correcta1) $puntaje++;
if ($respuesta2 === $correcta2) $puntaje++;
if ($respuesta3 === $correcta3) $puntaje++;

// Calcular porcentaje
$porcentaje = ($puntaje / 3) * 100;
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resultados</title>
    <style>
        body { font-family: Arial, sans-serif; max-width: 600px; margin: 50px auto; padding: 20px; }
        .container { background: #f9f9f9; padding: 30px; border-radius: 10px; }
        .score { font-size: 24px; font-weight: bold; margin: 20px 0; padding: 15px; background: #e9ecef; border-radius: 5px; text-align: center; }
        .result-item { margin: 15px 0; padding: 10px; background: white; border-radius: 5px; }
        .correct { border-left: 4px solid #28a745; }
        .incorrect { border-left: 4px solid #dc3545; }
        .restart-btn { background: #007bff; color: white; padding: 12px 30px; border: none; border-radius: 5px; cursor: pointer; text-decoration: none; display: inline-block; }
        .restart-btn:hover { background: #0056b3; }
    </style>
</head>
<body>
    <div class="container">
        <h1>Resultados de la Encuesta</h1>
        <p>Hola, <strong><?php echo htmlspecialchars($usuario); ?></strong></p>
        
        <div class="score">
            Puntaje: <?php echo $puntaje; ?>/3 (<?php echo number_format($porcentaje, 0); ?>%)
        </div>
        
        <div class="results">
            <h3>Tus respuestas:</h3>
            
            <div class="result-item <?php echo ($respuesta1 === $correcta1) ? 'correct' : 'incorrect'; ?>">
                <strong>Pregunta 1:</strong> <?php echo $respuesta1; ?>
                <?php if ($respuesta1 === $correcta1): ?>
                    <span style="color: green;">✓ Correcta</span>
                <?php else: ?>
                    <span style="color: red;">✗ Incorrecta</span>
                <?php endif; ?>
            </div>
            
            <div class="result-item <?php echo ($respuesta2 === $correcta2) ? 'correct' : 'incorrect'; ?>">
                <strong>Pregunta 2:</strong> <?php echo $respuesta2; ?>
                <?php if ($respuesta2 === $correcta2): ?>
                    <span style="color: green;">✓ Correcta</span>
                <?php else: ?>
                    <span style="color: red;">✗ Incorrecta</span>
                <?php endif; ?>
            </div>
            
            <div class="result-item <?php echo ($respuesta3 === $correcta3) ? 'correct' : 'incorrect'; ?>">
                <strong>Pregunta 3:</strong> <?php echo $respuesta3; ?>
                <?php if ($respuesta3 === $correcta3): ?>
                    <span style="color: green;">✓ Correcta</span>
                <?php else: ?>
                    <span style="color: red;">✗ Incorrecta</span>
                <?php endif; ?>
            </div>
        </div>
        
        <a href="index.php" class="restart-btn">Hacer otra encuesta</a>
    </div>
</body>
</html>