<?php
// Procesar el formulario cuando se envía
session_start();
$errores = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usuario = htmlspecialchars(trim($_POST['usuario'])) ?? '';
    $password = $_POST['password'] ?? '';
    
    if ($usuario === '') {
        $errores['usuario'] = "Usuario no puede estar vacio";
    }


     
    if ($password === '') {
        $errores['password'] = "Password no puede estar vacio";
    }

    if (empty($errores)) {
    $_SESSION['usuario'] = $usuario;
    header("Location: mostrar_tabla.php");
    exit();
    }

 
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="https://cdn.simplecss.org/simple.min.css">
</head>
<body>
    <h2>Iniciar Sesión</h2>
    
    <form method="POST" action="">
        <div>
            <label for="usuario">Usuario:</label>
            <input type="text" id="usuario" name="usuario">
            <?php if (isset($errores['usuario'])): ?>
                <br><span style="color: red;"><?php echo $errores['usuario']; ?></span>
            <?php endif; ?>
        </div>
        
        <div>
            <label for="password">Contraseña:</label>
            <input type="password" id="password" name="password">
            <?php if (isset($errores['password'])): ?>
                <br><span style="color: red;"><?php echo $errores['password']; ?></span>
            <?php endif; ?>
        </div>
        
        <div>
            <button type="submit">Ingresar</button>
        </div>
        
       
    </form>
    
</body>
</html>