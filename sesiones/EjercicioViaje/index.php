<?php
// Iniciar la sesión
session_start();

$errores = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
   $destino = htmlspecialchars(trim($_POST['destino'])) ?? '';
   $diasForm = $_POST['dias'] ?? 'dias';


   if (is_numeric($diasForm)) {
       $dias = intval($diasForm);
   } else {
       $errores['dias'] = "Introduzca un día válido.";
   }


   if (empty($destino)) {
       $errores['destino'] = "El destino no puede estar vacío.";
   }


   if (empty($dias) || $dias < 1) {
       $errores['dias'] = "Los días no pueden estar vacíos o deben ser más de un día.";
   }

  
   if (empty($errores)) {
       $_SESSION['viaje'] = [
           'destino' => $destino,
           'dias' => $dias,
           'itinerario' => []
       ];

       // Crear el itinerario con los días
       for ($i = 0; $i < $dias; $i++) {
           $_SESSION['viaje']['itinerario'][] = "Día: " . ($i + 1); 
       }

      
       header("Location: planificar.php", true, 302);
       exit();
   } else {
    
       $errores = "Error al cargar los datos.";
   }
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
<body>
    <h1>Planifica tu viaje</h1>

    <form action="index.php" method="post">
        <label for="destino">Destino:</label>
        <input type="text" id="destino" name="destino">
        <br>
        <label for="dias">Número de días:</label>
        <input type="number" id="dias" name="dias">
        <br>
        <input type="submit" value="Planificar Viaje">
    </form>

    <p class="notice">
        <?php
        if (!empty($errores)) {
            echo $errores;
        }
        ?>
        No hay viajes programados.
    </p>
</body>
</html>
