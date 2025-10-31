<?php
//inicializamos las variables
$mensaje = "";
$tareas = [];
//recuperamos del formulario los campos
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['accion']=='Agregar Tarea') {
    $tarea = $_POST['tarea'] ?? '';
    //tengo que des-serializar el array
    $array_serializado = $_POST['tarea_serializado'] ?? '';
    $tareas = unserialize($array_serializado);

    //validamos la tarea
    if (empty($tarea)) {
        $mensaje = "La tarea debe contener un texto";
    }elseif (in_array($tarea, $tareas)){
        $mensaje = "La tarea ya existe";
    } 
    else {
        //añadimos la tarea al array
        $tareas[] = $tarea;
    }
}
if (empty($tareas)) $mensaje="No hay tareas !";

//serializamos el array de tareas
$tareas_serializado = serialize($tareas);

?>
<!DOCTYPE html>
<html lang='es'>

<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>P.Lluyot</title>
    <link rel='stylesheet' href='https://cdn.simplecss.org/simple.min.css'>
</head>

<body>

    <header>
        <h1>Ejercicio con formularios y arrays serializados</h1>
    </header>
    <main>
        <h2>Registrar Tarea</h2>
        <form method="POST" action="">
            <p>
                <label for="tarea">Tarea:</label>
                <input type="text" id="tarea" name="tarea">
                <input type="hidden" name="tarea_serializado" id="tarea_serializado" value="<?php echo (htmlspecialchars($tareas_serializado ?? '')); ?>">
            </p>
            <input type="submit" value="Agregar Tarea" name="accion">
            <input type="submit" value="Borrar Tareas" name="accion">
            <input type="reset" value="Botón Reset">
        </form>

        <h2>Tareas Registradas</h2>
        <ol>
            <?php foreach ($tareas as $tarea): ?>
                <li><?= htmlspecialchars($tarea); ?></li>
            <?php endforeach; ?>
        </ol>
        <?php if (!empty($mensaje)) : ?>
            <p class='notice'><?= $mensaje; ?></p>
        <?php endif; ?>
    </main>
    <footer>
        <p>P.Lluyot</p>
    </footer>
</body>

</html>