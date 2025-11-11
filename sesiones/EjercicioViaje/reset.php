


<?php
session_start();
session_unset();
session_destroy();
header('Location: index.php');
exit;
?>



<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <label>Pon lo que se pida:<br>
    <button id="elemento" type="button">Pon lo que quieras</button>
    </label>
    
</body>
</html>