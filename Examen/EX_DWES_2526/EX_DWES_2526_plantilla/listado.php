<?php
/* ############################## CÓDIGO PHP ################################################

# ================= Apartado 3: Lectura de fichero y generación de tabla (2 puntos) ==========
# - Lee los datos de libros.csv y genera la tabla HTML con los libros registrados.

# ================= Apartado 4: Funciones PHP (1 punto) ======================================
# - Implementa funciones auxiliares para cargar libros y generar la tabla.

# ================= Apartado 5: Filtro por género (1,5 puntos) ===============================
# - Permite filtrar los libros por género mediante un formulario GET.

# ================= Apartado 6: Estadísticas (1,5 puntos) ====================================
# - Calcula y muestra el total de libros y el número de libros por género.

# ############################# FIN CÓDIGO PHP ############################################## */

// ================= Apartado 4: Funciones PHP (1 punto) ======================================
function arrayATabla($array, $titulo = '') {
    if (empty($array)) return "<p>No hay datos</p>";
    
    $html = '';
    if ($titulo) {
        $html .= "<h3>$titulo</h3>";
    }
    
    $html .= '<table border="1" style="border-collapse: collapse; width: 100%;">';
    
    // Detectar si es array de arrays
    $esMultidimensional = is_array($array[0] ?? null);
    
    if ($esMultidimensional) {
        // Generar encabezados desde las keys del primer elemento
        $html .= '<tr>';
        foreach (array_keys($array[0]) as $header) {
            $html .= "<th style='padding: 8px;'>" . htmlspecialchars($header) . "</th>";
        }
        $html .= '</tr>';
        
        // Generar filas
        foreach ($array as $fila) {
            $html .= '<tr>';
            foreach ($fila as $valor) {
                $html .= "<td style='padding: 8px;'>" . htmlspecialchars($valor) . "</td>";
            }
            $html .= '</tr>';
        }
    } else {
        // Array simple
        $html .= '<tr>';
        foreach ($array as $valor) {
            $html .= "<td style='padding: 8px;'>" . htmlspecialchars($valor) . "</td>";
        }
        $html .= '</tr>';
    }
    
    $html .= '</table>';
    return $html;
}

function cargarDatosSUPER($archivo, $formato = 'indexado')
{
    $datos = [];
    if (!file_exists($archivo)) return $datos;
    
    $manejador = @fopen($archivo, "r");
    if ($manejador) {
        // Leer primera línea para detectar encabezados - USANDO PUNTO Y COMO
        $primeraLinea = fgetcsv($manejador, 0, ';');
        if ($primeraLinea === false) {
            fclose($manejador);
            return $datos;
        }
        
        // Verificar si la primera línea parece encabezados (no numérica)
        $tieneEncabezados = false;
        if ($formato === 'auto') {
            $tieneEncabezados = !is_numeric(trim($primeraLinea[0]));
        }
        
        // Si tiene encabezados, procesar de forma asociativa
        if ($tieneEncabezados) {
            $encabezados = $primeraLinea;
            while (!feof($manejador)) {
                $temp = fgetcsv($manejador, 0, ';'); // USANDO PUNTO Y COMO
                if ($temp === false || (count($temp) === 1 && empty(trim($temp[0])))) continue;
                
                $fila = [];
                foreach ($encabezados as $index => $encabezado) {
                    $fila[trim($encabezado)] = $temp[$index] ?? '';
                }
                $datos[] = $fila;
            }
        } else {
            // Si no tiene encabezados, procesar como indexado
            $datos[] = $primeraLinea; // Guardar la primera línea también
            while (!feof($manejador)) {
                $temp = fgetcsv($manejador, 0, ';'); // USANDO PUNTO Y COMO
                if ($temp === false || (count($temp) === 1 && empty(trim($temp[0])))) continue;
                $datos[] = $temp;
            }
        }
        
        fclose($manejador);
    }
    return $datos;
}


// Código principal
$archivo = "libros.csv";

// ================= Apartado 3: Lectura de fichero y generación de tabla (2 puntos) ==========
$libros = cargarDatosSUPER($archivo, 'auto');

// ================= Apartado 5: Filtro por género (1,5 puntos) ===============================
$genero_filtro = isset($_GET['genero']) ? $_GET['genero'] : 'Todos';
$generos_permitidos = ['Todos', 'Novela', 'Ciencia ficción', 'Fantasía'];
$genero_filtro = in_array($genero_filtro, $generos_permitidos) ? $genero_filtro : 'Todos';

// Aplicar filtro
if ($genero_filtro !== 'Todos') {
    $libros_filtrados = [];
    foreach ($libros as $libro) {
        if (isset($libro['Género']) && $libro['Género'] === $genero_filtro) {
            $libros_filtrados[] = $libro;
        }
    }
} else {
    $libros_filtrados = $libros;
}

// ================= Apartado 6: Estadísticas (1,5 puntos) ====================================
$total_libros = count($libros);
$estadisticas_generos = [
    'Novela' => 0,
    'Ciencia ficción' => 0,
    'Fantasía' => 0
];

foreach ($libros as $libro) {
    if (isset($libro['Género']) && isset($estadisticas_generos[$libro['Género']])) {
        $estadisticas_generos[$libro['Género']]++;
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
        <form method="GET">
            <label for="genero">Filtrar por género:</label>
            <select id="genero" name="genero">
                <option value="Todos" <?= $genero_filtro == 'Todos' ? 'selected' : '' ?>>Todos</option>
                <option value="Novela" <?= $genero_filtro == 'Novela' ? 'selected' : '' ?>>Novela</option>
                <option value="Ciencia ficción" <?= $genero_filtro == 'Ciencia ficción' ? 'selected' : '' ?>>Ciencia ficción</option>
                <option value="Fantasía" <?= $genero_filtro == 'Fantasía' ? 'selected' : '' ?>>Fantasía</option>
            </select>
            <button type="submit">Filtrar</button>
        </form>

        <!-- ================= Apartado 3: Tabla HTML de libros ============================= -->
        <?= arrayATabla($libros_filtrados) ?>

        <!-- ================= Apartado 6: Estadísticas ==================================== -->
        <section>
            <h3>Estadísticas de libros</h3>
            <p>Total de libros registrados: <?= $total_libros ?></p>
            <?php foreach ($estadisticas_generos as $genero => $cantidad): ?>
                <p>Número de libros de <?= $genero ?>: <?= $cantidad ?></p>
            <?php endforeach; ?>
        </section>
    </main>
    
    <!-- Pie de página con información del examen y autor -->
    <footer>
        <p><em>Examen-1 de DWES - Curso 2025-2026.</em></p>
        <p>P.Lluyot</p>
    </footer>
</body>
</html>