<?php
session_start();

// si el botón de reiniciar es presionado, resetea el contador
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['reiniciar'])) {
    unset($_SESSION['contadorVisitas']);    
}

// si la variable de sesión existe, incrementa el contador, si no, la inicializa
if (isset($_SESSION['contadorVisitas'])) {
    $_SESSION['contadorVisitas']++;
} else {
    $_SESSION['contadorVisitas'] = 1;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdn.simplecss.org/simple.min.css">
</head>
<body>

<form action="" method="post">
    <label><br>
    <button id="elemento" type="submit" name="recargar">Recarga la pagina</button>
    </label>
    <label><br>
    <button id="elemento" type="submit" name="reiniciar">Reiniciar el contador</button>
    </label>
</form>

<?php
echo "Has visitado esta página: " . $_SESSION['contadorVisitas'] . " veces.";
?>
    
</body>
</html>
