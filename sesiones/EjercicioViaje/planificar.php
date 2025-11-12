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
// bucle para mostrar las actividades por dia
for ($i = 0; $i < $dias; $i++) {
    $listaMensaje .= "<li><strong>Día " . ($i + 1) . ":</strong><ul>";
    if (isset($actividades[$i]) && is_array($actividades[$i]) && count($actividades[$i]) > 0) {
        foreach ($actividades[$i] as $actividad) {
            $listaMensaje .= "<li>" . htmlspecialchars($actividad) . "</li>";
        }
    } else {
        $listaMensaje .= "<li>No hay actividades planificadas.</li>";
    }
    $listaMensaje .= "</ul></li>";
}
$listaMensaje .= "</ul>";

// Generar opciones para el select
for ($i = 0; $i < $dias; $i++) { 
    $mensajeSelect .= '<option value="' . $i . '">Día ' . ($i + 1) . '</option>';
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $actividad = trim($_POST['actividad'] ?? '');
    $diaActividad = $_POST['diaActividad'] ?? '';

    if (empty($actividad)) {
        $errores['actividad'] = "La actividad no puede estar vacío.";
    }

    if ($diaActividad === '') {
        $errores['diaActividad'] = "Debe seleccionar un día.";
    }

    if (empty($errores)) {
        $_SESSION['viaje']['itinerario'][$diaActividad][] = $actividad;
        // Recargar la página para mostrar la nueva actividad
        header("Location: planificar.php");
        exit();
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

  <h2>Planificando tu viaje a <?php echo htmlspecialchars($destino) . " - Días: " . $dias; ?></h2>
    
    <form action="planificar.php" method="post">
      <label for="actividad">Nueva actividad:</label>
      <input type="text" id="actividad" name="actividad" required>  
      <br>
   
      <label for="diaActividad">Seleccionar día:</label>
      <select id="diaActividad" name="diaActividad" required>
        <option value="">Seleccione un día</option>
        <?php echo $mensajeSelect; ?>
      </select>
      <br>
      
      <button type="submit">Agregar actividad</button>
    
    </form>

    <?php if (!empty($errores)): ?>
        <div class="error">
            <?php foreach ($errores as $error): ?>
                <p><?php echo $error; ?></p>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <h4>Itinerario de tu viaje:</h4>
    <?php echo $listaMensaje; ?>

    <br>
   

</body>
</html>