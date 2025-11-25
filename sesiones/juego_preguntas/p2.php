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
    $respuesta2 = $_POST['respuesta2'] ?? '';
    $respuestaSeleccionada = $respuesta2;

    // ✅ CORREGIDO: Usar $respuesta2 en lugar de $respuesta
    if ($respuesta2 === '') {
        $errores = "Seleccione una opcion.";
    }

    if (empty($errores)) {
        // ✅ CORREGIDO: Guardar $respuesta2 en lugar de $respuesta
        $_SESSION['respuesta2'] = $respuesta2;
        header("Location: p3.php", true, 302);
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pregunta 2</title>
    <style>
        body { font-family: Arial, sans-serif; max-width: 600px; margin: 50px auto; padding: 20px; }
        .container { background: #f9f9f9; padding: 30px; border-radius: 10px; }
        .welcome { color: #007bff; margin-bottom: 20px; }
        .question { margin-bottom: 20px; font-weight: bold; }
        .options label { display: block; margin: 10px 0; cursor: pointer; }
        button { background: #007bff; color: white; padding: 12px 30px; border: none; border-radius: 5px; cursor: pointer; }
        button:hover { background: #0056b3; }
        .error { color: red; margin-top: 10px; font-weight: bold; }
    </style>
</head>
<body>
    <div class="container">
        <div class="welcome">
            <h1>Pregunta 2</h1>
            <p>Hola, <strong><?php echo htmlspecialchars($usuario); ?></strong></p>
        </div>
        
        <form action="" method="POST">
            <div class="question">
                <p>¿Qué tipo de proyectos prefieres desarrollar?</p>
            </div>
            
            <div class="options">
                <!-- ✅ CORREGIDO: checked va como atributo, no en value -->
                <label>
                    <input type="radio" name="respuesta2" value="web" 
                           <?php echo ($respuestaSeleccionada === 'web') ? 'checked' : ''; ?>> 
                    Desarrollo Web
                </label>
                <label>
                    <input type="radio" name="respuesta2" value="mobile"
                           <?php echo ($respuestaSeleccionada === 'mobile') ? 'checked' : ''; ?>> 
                    Aplicaciones Móviles
                </label>
                <label>
                    <input type="radio" name="respuesta2" value="data"
                           <?php echo ($respuestaSeleccionada === 'data') ? 'checked' : ''; ?>> 
                    Ciencia de Datos
                </label>
                <label>
                    <input type="radio" name="respuesta2" value="games"
                           <?php echo ($respuestaSeleccionada === 'games') ? 'checked' : ''; ?>> 
                    Desarrollo de Videojuegos
                </label>
            </div>
            
            <!-- ✅ CORREGIDO: Usar !empty() en lugar de isset() -->
            <?php if (!empty($errores)): ?>
                <div class="error"><?php echo $errores; ?></div>
            <?php endif; ?>
            
            <button type="submit">Siguiente</button>
        </form>
    </div>
</body>
</html>