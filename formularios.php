<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>

<form  method="POST" action="<?=$_SERVER['PHP_SELF']?>"
<label for="nombre"> Nombre:</label>
<input type="text" name="nombre" id="nombre">
<button type="submit">Enviar</button>

<?php
if ($_SERVER['REQUEST_METHOD']=== 'POST') {
    //  // Sanitizar la entrada
    // $nombre = htmlspecialchars(trim($_POST['nombre']));
    echo "<p> Hola, " . $_POST['nombre'] . "!</p>";
}

?>

</form>
    
</body>
</html>