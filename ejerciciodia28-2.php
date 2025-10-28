<?php

$mensajeExito = "";
$errores = [];

$mensajeTabla = "";

$nombre = "";
$apellidos = "";
$email = "";
$peso = "";
$altura = "";
$pesos = [];
$alturas = [];
$totalPersonas = 0;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['enviar'])) {

    $nombre = isset($_POST['nombre']) ? htmlspecialchars($_POST['nombre']) : '';
    $apellidos = isset($_POST['apellidos']) ? htmlspecialchars($_POST['apellidos']) : '';
    $email = isset($_POST['email']) ? htmlspecialchars($_POST['email']) : '';
    $peso = isset($_POST['peso']) ? htmlspecialchars($_POST['peso']) : '';
    $altura = isset($_POST['altura']) ? htmlspecialchars($_POST['altura']) : '';

    if (empty($nombre)) {
        $errores['nombre'] = "El nombre no puede estar vacío";
    } 
    if (empty($apellidos)) {
        $errores['apellidos'] = "Los apellidos no pueden estar vacíos.";
    }

    if (empty($email)) {
        $errores['email'] = "El email es obligatorio";
    } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errores['email'] = "El formato del email no es válido";
    }

    if (empty($peso)) {
        $errores['peso'] = "El peso no ha sido introducido.";
    } elseif (!is_numeric($peso) || intval($peso) < 0) {
        $errores['peso'] = "Debe ser un peso correcto.";
    }

    if (empty($altura)) {
        $errores['altura'] = "La altura no ha sido introducida.";
    } elseif (!is_numeric($altura) || floatval($altura) < 1 || floatval($altura) > 2.5) {
        $errores['altura'] = "Debe ser una altura correcta.";
    }

    // Si no hay errores, guardamos el registro
    if (empty($errores)) {
        $archivo = @fopen('ejerciciodia28-2.csv', 'a+');

        $datos = [
            $nombre,
            $apellidos,
            $email,
            $peso,
            $altura,
        ];

        if (fputcsv($archivo, $datos)) {
            $mensajeExito = "¡Registro completado correctamente!";
        } else {
            $mensajeError = "Error al guardar los datos. Inténtalo de nuevo.";
        }

        fclose($archivo);
    }

    // Leer el archivo CSV para calcular max, min y promedio de peso y altura
    if (($archivo = @fopen('ejerciciodia28-2.csv', 'r')) !== false) {
        while (($data = fgetcsv($archivo)) !== false) {
            // para contar las personas
             $totalPersonas++;
            // el peso está en la cuarta columna y la altura en la quinta
            if (isset($data[3]) && is_numeric($data[3])) {
                $pesos[] = floatval($data[3]); 
            }
            if (isset($data[4]) && is_numeric($data[4])) {
                $alturas[] = floatval($data[4]); 
            }
        }
        fclose($archivo);
    }

    // calcular max, min y promedio con array_sum
    $pesoMaximo = $pesoMinimo = $promedioPeso = 0;
    if (count($pesos) > 0) {
        $pesoMaximo = max($pesos);
        $pesoMinimo = min($pesos);
        $promedioPeso = array_sum($pesos) / count($pesos);
    }

    $alturaMaxima = $alturaMinima = $promedioAltura = 0;
    if (count($alturas) > 0) {
        $alturaMaxima = max($alturas);
        $alturaMinima = min($alturas);
        $promedioAltura = array_sum($alturas) / count($alturas);
    }

    // Generar tabla con los resultados
    $mensajeTabla = "
   <table>
    <thead>
        <tr>
            <th colspan='7'>Total de Personas: $totalPersonas</th>
        </tr>
        <tr>
            <th>Max Peso</th>
            <th>Min Peso</th>
            <th>Promedio Peso</th>
            <th>Max Altura</th>
            <th>Min Altura</th>
            <th>Promedio Altura</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>$pesoMaximo</td>
            <td>$pesoMinimo</td>
            <td>$promedioPeso</td>
            <td>$alturaMaxima</td>
            <td>$alturaMinima</td>
            <td>$promedioAltura</td>
        </tr>
    </tbody>
</table>";
}

?>






<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdn.simplecss.org/simple.min.css">
    <style>
        .error {
    color: red;
    font-size: 0.9em;
    display: block;
}

.hidden {
    display: none;
}

    </style>
</head>

<body>


    <form action="" method="post">

    <!-- Nombre -->
    <label for="nombre">Nombre</label>
    <input type="text" id="nombre" name="nombre" value="<?php echo $nombre; ?>">
    <span class="error <?php echo empty($errores['nombre']) ? 'hidden' : ''; ?>">
        <?php echo $errores['nombre']; ?>
    </span>

    <!-- Apellidos -->
    <label for="apellidos">Apellidos</label>
    <input type="text" id="apellidos" name="apellidos" value="<?php echo $apellidos; ?>">
    <span class="error <?php echo empty($errores['apellidos']) ? 'hidden' : ''; ?>">
        <?php echo $errores['apellidos']; ?>
    </span>

    <!-- Email -->
    <label for="email">Email</label>
    <input type="email" id="email" name="email" value="<?php echo $email; ?>">
    <span class="error <?php echo empty($errores['email']) ? 'hidden' : ''; ?>">
        <?php echo $errores['email']; ?>
    </span>

    <!-- Peso -->
    <label for="peso">Peso (kg)</label>
    <input type="number" step="0.1" id="peso" name="peso" value="<?php echo $peso; ?>">
    <span class="error <?php echo empty($errores['peso']) ? 'hidden' : ''; ?>">
        <?php echo $errores['peso']; ?>
    </span>

    <!-- Altura -->
    <label for="altura">Altura (m)</label>
    <input type="number" step="0.01" id="altura" name="altura" value="<?php echo $altura; ?>">
    <span class="error <?php echo empty($errores['altura']) ? 'hidden' : ''; ?>">
        <?php echo $errores['altura']; ?>
    </span>

    <br><br>
    <button type="submit" name="enviar">Guardar</button>

</form>

    </form>

  <!-- Mensaje de éxito -->
    <?php if (!empty($mensajeExito)) : ?>
        <div class="success">
            <?php echo $mensajeExito; ?>
        </div>
    <?php endif; ?>

    <!-- Mostrar tabla con los resultados de peso y altura -->
    <?php if (!empty($mensajeTabla)) : ?>
        <div class="resultados">
            <?php echo $mensajeTabla; ?>
        </div>
    <?php endif; ?>


</body>

</html>