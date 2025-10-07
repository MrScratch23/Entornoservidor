
<?php
if ($_SERVER['REQUEST_METHOD']=== 'GET') {
    $nombre = $_GET['nombre'] ?? '';
    $apellidos = $_GET['apellidos'] ?? '';
    $mensaje = [];

    if ($nombre === "" && $apellidos === "") {
        $mensaje []= "El nombre y/o apellidos no deben estar vacios";
    }





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

   </form>
    
</body>
</html>