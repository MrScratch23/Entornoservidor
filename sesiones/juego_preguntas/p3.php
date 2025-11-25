<?php
session_start();

if (!isset($_SESSION['usuario'])) {
    header("Location: index.php", true, 302);
    exit();
}

$usuario = $_SESSION['usuario'];
$errores = "";
$respuestaSeleccionada = ''; // Variable para mantener la selección

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $respuesta3 = $_POST['respuesta3'] ?? '';
    $respuestaSeleccionada = $respuesta3;

    if ($respuesta3 === '') {
        $errores = "Seleccione una opcion.";
    }

    if (empty($errores)) {
        
        $_SESSION['respuesta3'] = $respuesta3;
        header("Location: resultado.php", true, 302);
        exit();
    }
}
?>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pregunta 3</title>
    <style>
        body { font-family: Arial, sans-serif; max-width: 600px; margin: 50px auto; padding: 20px; }
        .container { background: #f9f9f9; padding: 30px; border-radius: 10px; }
        .welcome { color: #007bff; margin-bottom: 20px; }
        .question { margin-bottom: 20px; font-weight: bold; }
        .options label { display: block; margin: 10px 0; cursor: pointer; }
        button { background: #28a745; color: white; padding: 12px 30px; border: none; border-radius: 5px; cursor: pointer; }
        button:hover { background: #218838; }
        .error { color: red; margin-top: 10px; font-weight: bold; }
    </style>
</head>
<body>
    <div class="container">
        <div class="welcome">
            <h1>Pregunta 3</h1>
            <p>Hola, <strong><?php echo htmlspecialchars($usuario); ?></strong></p>
        </div>
        
        <form action="" method="POST">
            <div class="question">
                <p>¿Cuál es tu nivel de experiencia en programación?</p>
            </div>
            
            <div class="options">
                <label>
                    <input type="radio" name="respuesta3" value="principiante" 
                           <?php echo ($respuestaSeleccionada === 'principiante') ? 'checked' : ''; ?>> 
                    Principiante
                </label>
                <label>
                    <input type="radio" name="respuesta3" value="intermedio"
                           <?php echo ($respuestaSeleccionada === 'intermedio') ? 'checked' : ''; ?>> 
                    Intermedio
                </label>
                <label>
                    <input type="radio" name="respuesta3" value="avanzado"
                           <?php echo ($respuestaSeleccionada === 'avanzado') ? 'checked' : ''; ?>> 
                    Avanzado
                </label>
                <label>
                    <input type="radio" name="respuesta3" value="experto"
                           <?php echo ($respuestaSeleccionada === 'experto') ? 'checked' : ''; ?>> 
                    Experto
                </label>
            </div>

            <?php if (!empty($errores)): ?>
                <div class="error"><?php echo $errores; ?></div>
            <?php endif; ?>
            
            <button type="submit">Ver Resultados</button>
        </form>
    </div>
</body>
</html>