
<?php
session_start();

if (!isset($_SESSION['viaje'])) {
    header("Location: index.php", true, 302);
    exit();
}

$destino = $_SESSION['viaje']['destino'];
$dias = $_SESSION['viaje']['dias'];
$actividades = $_SESSION['viaje']['itinerario'];
$errores = [];

$mensajeSelect = "";


$listaMensaje = "<ul>";

$listaMensaje .= "</ul>";


for ($i=0; $i < count($actividades) ; $i++) { 
$mensajeSelect .= '<option value="' .$i. '">' . htmlspecialchars($actividades[$i]) . '</option>';
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $actividad = $_POST['actividad'] ?? '';
    $diaActividad = $_POST['diaActividad'] ?? '';


    if (empty($actividad)) {
        $errores['actividad'] = "La actividad no puede estar vacio.";
    }

    if (empty($diaActividad)) {
        $errores ['diaActividad'] = "Los dias no pueden estar vacios.";
    }

    if (empty($errores)) {
    $_SESSION['viaje']['itinerario'][$diaActividad][]= $actividad;

    }




}




?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Viaje</title>
    <link rel="stylesheet" href="https://cdn.simplecss.org/simple.min.css">
</head>
<body>

  <h2>Planificando tu viaje a <?php
   echo "$destino Dias: $dias" ;
    ?></h2>
    
    <form action="planificar.php" method="post">
      <label for="actividades">Nueva actividad:</label>
      <input type="text" id="actividad" name="actividad" required>  
      <br>
   
      <select id="diaActividad" name="diaActividad">
    <?php
    echo $mensajeSelect;
    ?>
      </select>
      
      <button id="agregar" type="submit">Agregar tareas</button>
    
    </form>
    <h4>Lista de actividades:</h4>

    <p class="notice">
   <?php
   echo $listaMensaje;
   ?>


    </p>



</body>
</html>