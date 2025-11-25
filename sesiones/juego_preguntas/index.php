<?php
session_start();
$errores = [];

if (isset($_SESSION['usuario'])) {
    header("Location: p1.php", true, 302);
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = trim($_POST['nombre'] ?? ''); // Quita htmlspecialchars de aquí

    if ($nombre === '') {
        $errores['nombre'] = "El nombre no puede estar vacio.";
    }

    if (empty($errores)) {
           $_SESSION['usuario'] = $nombre;
           header("Location: p1.php", true, 302);
           exit();
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Encuesta Interactiva</title>
    <style>
        body { font-family: Arial, sans-serif; max-width: 600px; margin: 50px auto; padding: 20px; }
        .container { background: #f9f9f9; padding: 30px; border-radius: 10px; }
        .form-group { margin-bottom: 20px; }
        label { display: block; margin-bottom: 8px; font-weight: bold; }
        input[type="text"] { width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 5px; }
        button { background: #007bff; color: white; padding: 12px 30px; border: none; border-radius: 5px; cursor: pointer; }
        button:hover { background: #0056b3; }
        .error { color: red; margin-top: 5px; }
    </style>
</head>
<body>
    <div class="container">
        <h1>Encuesta Interactiva</h1>
        <p>¡Bienvenido! Por favor, ingresa tu nombre para comenzar la encuesta.</p>
        
        <form action="" method="POST">
            <div class="form-group">
                <label for="nombre">Tu nombre:</label>
                <input type="text" id="nombre" name="nombre" value="<?php echo htmlspecialchars($nombre ?? ''); ?>">
                <?php if (isset($errores['nombre'])): ?>
                    <div class="error"><?php echo $errores['nombre']; ?></div>
                <?php endif; ?>
            </div>
            <button type="submit">Comenzar Encuesta</button>
        </form>
    </div>
</body>
</html>