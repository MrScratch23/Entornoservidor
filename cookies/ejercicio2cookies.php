<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['enviar'])) {
    $color = isset($_POST['color']) ? htmlspecialchars($_POST['color']) : '#ffffff';
   
    setcookie("colorfondo", $color, time() + (7*24*60*60), "/");

    $colorfondo = $color;
    header("Location: ejercicio2cookies.php");
    exit();
} else {
    
    $colorfondo = isset($_COOKIE['colorfondo']) ? $_COOKIE['colorfondo'] : '#ffffff';
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdn.simplecss.org/simple.min.css">
</head>
<body style="background-color: <?= htmlspecialchars($colorfondo) ?>;">

<form action="" method="post">
    <label for="color">Elige un color:</label>
    <input type="color" id="color" name="color" value="<?= htmlspecialchars($colorfondo) ?>">
    <input type="submit" value="Guardar color">
</form>

</body>
</html>
