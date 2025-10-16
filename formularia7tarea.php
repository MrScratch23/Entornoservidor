<?php
// inicializar variables
$tareas = [];
$array_texto = '';
$mensaje = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $accion = $_POST['accion'] ?? '';
    $tarea = trim($_POST['tarea'] ?? '');

   
    

    $array_serializado = $_POST['tareas_ser'] ?? '';
    $tareas = $array_serializado ? unserialize($array_serializado) : [];

    if ($accion === 'agregar') {
        if (empty($tarea)) {
            $mensaje = "El campo no debe estar vacío.";
        } else {
            $tareas[] = $tarea;
            $mensaje = "Tarea agregada correctamente.";
        }
    } elseif ($accion === 'borrar') {
        $tareas = [];
        $mensaje = "Todas las tareas han sido borradas.";
    }


    // ponerlo fuera del if para que no de problemas
    $tareas_ser = serialize($tareas);
    $array_texto = $tareas_ser;
}


?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Lista de Tareas</title>
    <link rel="stylesheet" href="https://cdn.simplecss.org/simple.min.css" />
</head>

<body>

    <h1>Lista de Tareas</h1>

    <form action="" method="POST">
        <p>
            <label for="tarea">Nueva Tarea:</label>

            <input type="text" id="tarea" name="tarea">

            <input type="hidden" name="tareas_ser" value="<?= htmlspecialchars($array_texto) ?>">
        </p>

        <button type="submit" name="accion" value="agregar">Agregar Tarea</button>
        <button type="submit" name="accion" value="borrar">Borrar Todas</button>
        <input type="reset" value="Boton Reset">
    </form>

    <?php if ($mensaje): ?>
        <p class="notice"><?= htmlspecialchars($mensaje) ?></p>
    <?php endif; ?>

    <h2>Tareas registradas:</h2>

    <?php if (count($tareas) > 0): ?>
        <ol>
            <?php foreach ($tareas as $tarea): ?>
                <li><?= htmlspecialchars($tarea) ?></li>
            <?php endforeach; ?>
        </ol>
    <?php else: ?>
        <p>No hay tareas registradas.</p>
    <?php endif; ?>

</body>

</html>