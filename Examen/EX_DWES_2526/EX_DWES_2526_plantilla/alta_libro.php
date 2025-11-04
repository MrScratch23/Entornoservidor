<!-- 
    Página de alta de libros de la Biblioteca Local
    Autor: P.Lluyot
    Examen-1 de DWES - Curso 2025-2026
-->

<!-- 
    Página de alta de libros de la Biblioteca Local
    Autor: P.Lluyot
    Examen-1 de DWES - Curso 2025-2026
-->
<?php
/* ############################## CÓDIGO PHP ################################################

# ================= APARTADO 1: Formulario y validación (2 puntos) ==========================

# ================= APARTADO 2: Grabación en fichero (1 punto) ==============================

# ############################# FIN CÓDIGO PHP ############################################## */

// funciones utiles
// funcion para validar numeros
function validarNumero($numero, $min = null, $max = null)
{
    if (!is_numeric($numero)) return false;
    if ($min !== null && $numero < $min) return false;
    if ($max !== null && $numero > $max) return false;
    return true;
}

function guardarArrayAsociativoCSV($archivo, $arrayAsociativo)
{
  // funcion para guardar un array asociativo en un archivo CSV
    $manejador = @fopen($archivo, "a+");
    if ($manejador) {
        fputcsv($manejador, $arrayAsociativo);
        fclose($manejador);
        return true;
    }
    return false;
}

// creo variables de las que hare uso en el futuro
$titulo = "";
$autor = "";
$aniopublicacion = "";
$genero = "";
// array asoc para los errores
$errores = [
    'titulo' => '',
    'autor' => '',
    'anio' => '',
    'genero' => '',
];

$mensajeExito = "";
$mensajeError = "";
$archivo = "libros.csv";

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['registrar'])) {
    // sanitizo los datos
    $titulo = htmlspecialchars(trim($_GET['titulo'])) ?? '';
    $autor = htmlspecialchars(trim($_GET['autor'])) ?? '';
    $aniopublicacion = $_GET['anio'] ?? '';
    $genero = htmlspecialchars(trim($_GET['genero'])) ?? '';

    // compruebo los errores, guardandolos en el array
    if (empty($titulo)) {
        $errores['titulo'] = "El titulo no puede estar vacio.";
    }
    if (empty($autor)) {
        $errores['autor'] = "El autor no puede estar vacio.";
    }

    if (empty($aniopublicacion)) {
        $errores['anio'] = "Debe introducir un año";
    }
    $anioPlub = intval($aniopublicacion);

    if (validarNumero($anioPlub, 1800, 2100)) {
        $errores['anio'] = "La fecha debe estar comprendida entre 1800-2100";
    }

    if (empty($genero)) {
        $errores['genero'] = "El genero no puede estar vacio";
    }

    if ($genero != "Novela" || $genero != "Ciencia ficción" || $genero != "Fantasía") {
        $errores['genero'] = "El genero introducido debe ser uno de los permitidos: Novela - Ciencia ficcion - Fantasía";
    }




    // creo el array de libros con los datos del formulario
    $libro = [$titulo, $autor, $anioPlub, $genero];


    // booleano de control
    $hayErrores = false;
    foreach ($errores as $error) {
        if (!empty($error)) {
            $hayErrores = true;
            break;
        }
    }
    // si los errores estan vacios, los meto al csv con la funcion
    if (!$hayErrores) {
        if (guardarArrayAsociativoCSV($archivo, $libro)) {
            $mensajeExito = "Libro guardado con exito.";
        } else {
            $mensajeError = "No se pudo guardar el libro correctamente.";
        }
    }
}


?>
<!DOCTYPE html>
<html lang='es'>

<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>P.Lluyot</title>
    <!-- Hoja de estilos principal de simple.css -->
    <link rel='stylesheet' href='https://cdn.simplecss.org/simple.min.css'>
    <!-- Hoja de estilos personalizada para la biblioteca -->
    <link rel='stylesheet' href='css/biblioteca.css'>
</head>

<body>
    <!-- Cabecera de la página con título y menú de navegación -->
    <header>
        <h2>📚 Biblioteca Local</h2>
        <nav>
            <a href="index.php">🏠 Página principal</a>
            <a href="alta_libro.php" class="active">💾 Registrar libro</a>
            <a href="listado.php">📋 Listado de libros</a>
        </nav>
    </header>
    <!-- Contenido principal: formulario de alta de libros -->
    <main>
        <form>
            <p>
                <!-- Campo para el título del libro -->
                <!-- Mostrar los errores si los hubiese con un campo span-->
                <label for="titulo">Título del libro</label>
                <input type="text" id="titulo" name="titulo" value="<?php echo htmlspecialchars($titulo); ?>" size="40">
                <!-- Mostrar los errores si los hubiese con un campo span-->
                <?php if (!empty($errores['titulo'])) echo "<span class='error'>{$errores['titulo']}</span>"; ?>

                <!-- Campo para el autor del libro -->
                <label for="autor">Autor</label>
                <input type="text" id="autor" name="autor" value="<?php echo htmlspecialchars($autor); ?>" valuesize="40">
                <?php if (!empty($errores['autor'])) echo "<span class='error'>{$errores['autor']}</span>"; ?>

                <!-- Campo para el año de publicación -->
                <label for="anio">Año de publicación</label>
                <input type="number" id="anio" name="anio" value="<?php echo htmlspecialchars($anio); ?>" valuesize="40">
                <?php if (!empty($errores['anio'])) echo "<span class='error'>{$errores['anio']}</span>"; ?>
                <!-- Campo para el género del libro -->
                <label for="genero">Género</label>
                <select id="genero" name="genero">
                    <option value="">Selecciona un género</option>
                    <option value="Novela">Novela</option>
                    <option value="Ciencia ficción">Ciencia ficción</option>
                    <option value="Fantasía">Fantasía</option>
                </select>
                <?php if (!empty($errores['genero'])) echo "<span class='error'>{$errores['genero']}</span>"; ?>
            </p>
            <!-- Botón para enviar el formulario -->
            <button type="submit" name="registrar">
                💾 Registrar Libro
            </button>
        </form>
        <!-- Mensaje de notificación o resultado -->
        <p class='notice'>
            <?php if (isset($mensajeExito)): ?>

                <?php echo $mensajeExito; ?>

            <?php endif; ?>

            <?php if (isset($mensajeError)): ?>

                <?php echo $mensajeError; ?>

            <?php endif; ?>

        </p>
    </main>
    <footer>
        <p><em>Examen-1 de DWES - Curso 2025-2026.</em></p>
        <p>P.Lluyot</p>
    </footer>
</body>

</html>