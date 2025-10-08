<?php
if ($_SERVER['REQUEST_METHOD']=== 'GET') {
    $nombre = $_GET['nombre'] ?? '';
    $apellidos = $_GET['apellidos'] ?? '';
    $mensaje = [];
    $longitud_nombre = strlen($nombre);
    $longitud_apellidos = strlen($apellidos);

    if ($nombre === "" && $apellidos === "") {
        $mensaje []= "El nombre y/o apellidos no deben estar vacios";
    }
    
    if ($longitud_nombre >=25 || $longitud_apellidos >= 35) {
        $mensaje [] = "El nombre y/o apellidos superan la longitud maxima permitida";
    }
         if (empty($mensaje)) {
        $mensaje[] = "Nombre y apellidos correctos.";
    }



   // hay que transformar el array en string
    $mensaje_texto = implode("<br>", $mensaje);

}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>Empleado</h1>

   <form method="get" action="<?= htmlspecialchars($_SERVER['PHP_SELF']) ?>">

      <label for="nombre">Nombre:</label>
        <input type="text" name="nombre" id="nombre" value="<?= htmlspecialchars($nombre) ?>" required />
        <br><br>

        <label for="apellido">Apellidos:</label>
        <input type="text" name="apellidos" id="apellidos" value="<?= htmlspecialchars($apellidos) ?>" required />
        <br><br>

        <input type="submit" value="Enviar">

   </form>

      
   <?php if (!empty($mensaje_texto)): ?>
        <?= $mensaje_texto ?>
   <?php endif; ?>
    
    
</body>
</html>