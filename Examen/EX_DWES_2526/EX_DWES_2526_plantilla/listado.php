<?php
/* ############################## CÓDIGO PHP ################################################

# ================= Apartado 3: Lectura de fichero y generación de tabla (2 puntos) ==========
# - Lee los datos de libros.csv y genera la tabla HTML con los libros registrados.

# ================= Apartado 4: Funciones PHP (1 punto)  corrigeme esto======================================
# - Implementa funciones auxiliares para cargar libros y generar la tabla.

# ================= Apartado 5: Filtro por género (1,5 puntos) ===============================
# - Permite filtrar los libros por género mediante un formulario GET.

# ================= Apartado 6: Estadísticas (1,5 puntos) ====================================
# - Calcula y muestra el total de libros y el número de libros por género.

# ############################# FIN CÓDIGO PHP ############################################## */

// funciones utiles
$mensaje = "";
$archivo = "libros.csv";

function cargarLibros($archivo) {
    // cargar libros desde un archivo CSV
    $libros = [];
    if (!file_exists($archivo)) return $libros;

    $manejador = @fopen($archivo, "r");
    if ($manejador) {
        while (!feof($manejador)) {
            $temp = fgetcsv($manejador);
            if ($temp == false || count($temp) < 3) continue;
            else $libros[] = $temp;
        }
        fclose($manejador);
    }
    return $libros;
}

function tablaArrayHTML($archivo, $titulo = '') {
    if (!file_exists($archivo)) return false;

    $html = '';
    if ($titulo) {
        $html .= "<h3>$titulo</h3>";
    }

    $html .= '<table border="1">';

    $handle = fopen($archivo, 'r');
    $esPrimeraLinea = true;

    while ($data = fgetcsv($handle)) {
        $html .= '<tr>';
        foreach ($data as $valor) {
            if ($esPrimeraLinea) {
                $html .= "<th>$valor</th>";
            } else {
                $html .= "<td>$valor</td>";
            }
        }
        $html .= '</tr>';
        $esPrimeraLinea = false;
    }

    fclose($handle);
    $html .= '</table>';
    return $html;
}

function arrayALista($array, $titulo = '') {
    if (empty($array)) return "<p>No hay datos</p>";

    $html = '';
    if ($titulo) {
        $html .= "<h3>$titulo</h3>";
    }

    $html .= '<ul>';

    foreach ($array as $valor) {
        $html .= "<li>$valor</li>";
    }

    $html .= '</ul>';
    return $html;
}

// código
$mensaje = "";
$archivo = "libros.csv";
$csvTabla = tablaArrayHTML($archivo, "Listado de libros");
$libros = cargarLibros($archivo);

if (!$csvTabla) {
    $mensaje = "No existe el fichero.";
}

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Validación de género
    $genero = isset($_GET['genero']) ? $_GET['genero'] : 'Todos';
    $genero = in_array($genero, ['Todos', 'Novela', 'Ciencia ficción', 'Fantasía']) ? $genero : 'Todos';

    $longitud = count($libros);
    $librosFantasia = [];
    $librosNovela = [];
    $librosCienciaFiccion = [];

    if ($genero === "Todos") {
        $mensaje = arrayALista($libros, "Todos los libros");
    }

    // mostrar libros según su género
    for ($i = 0; $i < $longitud; $i++) {
        if ($libros[$i][3] === "Fantasía") {
            $librosFantasia[] = $libros[$i][0] . " - " . $libros[$i][1] . " (" . $libros[$i][2] . ")";
        }
        if ($libros[$i][3] === "Novela") {
            $librosNovela[] = $libros[$i][0] . " - " . $libros[$i][1] . " (" . $libros[$i][2] . ")";
        }
        if ($libros[$i][3] === "Ciencia ficción") {
            $librosCienciaFiccion[] = $libros[$i][0] . " - " . $libros[$i][1] . " (" . $libros[$i][2] . ")";
        }
    }

    if ($genero === "Fantasía") {
        $mensaje = arrayALista($librosFantasia, "Libros de Fantasía");
    }
    if ($genero === "Novela") {
        $mensaje = arrayALista($librosNovela, "Libros de Novela");
    }
    if ($genero === "Ciencia ficción") {
        $mensaje = arrayALista($librosCienciaFiccion, "Libros de Ciencia ficción");
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
            <a href="alta_libro.php">💾 Registrar libro</a>
            <a href="listado.php" class="active">📋 Listado de libros</a>
        </nav>
    </header>
    <!-- Contenido principal: listado y filtrado de libros -->
    <main>
        <!-- ================= Apartado 5: Formulario de filtrado por género ================ -->
        <form>
            <label for="genero">Filtrar por género:</label>
            <select id="genero" name="genero">
                <option value="Todos" <?php echo $genero == 'Todos' ? 'selected' : ''; ?>>Todos</option>
                <option value="Novela" <?php echo $genero == 'Novela' ? 'selected' : ''; ?>>Novela</option>
                <option value="Ciencia ficción" <?php echo $genero == 'Ciencia ficción' ? 'selected' : ''; ?>>Ciencia ficción</option>
                <option value="Fantasía" <?php echo $genero == 'Fantasía' ? 'selected' : ''; ?>>Fantasía</option>
            </select>
            <button type="submit">Filtrar</button>
        </form>

        <!-- ================= Apartado 3: Tabla HTML de libros ============================= -->
        <?php echo $csvTabla; ?>
        
        <p class='notice'>
            <?php
            if ($mensaje) {
               echo $mensaje;
            }
            ?>
        </p>

        <section>
            <h3>Estadísticas de libros</h3>
            <p>Total de libros registrados: <?php echo count($libros); ?></p>
            <?php
            $generos = ["Novela" => 0, "Ciencia ficción" => 0, "Fantasía" => 0];
            foreach ($libros as $libro) {
                if (isset($generos[$libro[3]])) {
                    $generos[$libro[3]]++;
                }
            }
            foreach ($generos as $genero => $cantidad) {
                echo "<p>Número de libros de $genero: $cantidad</p>";
            }
            ?>
        </section>
    </main>
    <!-- Pie de página con información del examen y autor -->
    <footer>
        <p><em>Examen-1 de DWES - Curso 2025-2026.</em></p>
        <p>P.Lluyot</p>
    </footer>
</body>

</html>
