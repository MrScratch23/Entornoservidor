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
function cargarLibros($archivo) {
    $libros = [];
    if (!file_exists($archivo)) return $libros;
    
    $manejador = fopen($archivo, "r");
    if ($manejador) {
        // Saltar la primera línea (encabezados)
        fgetcsv($manejador, 0, ';');
        
        while (($datos = fgetcsv($manejador, 0, ';')) !== FALSE) {
            if (!empty($datos) && count($datos) >= 4) {
                $libros[] = $datos;
            }
        }
        fclose($manejador);
    }
    return $libros;
}

function generarTablaLibros($libros) {
    if (empty($libros)) {
        return "<p>No hay libros registrados</p>";
    }
    
    $html = '<table border="1">';
    $html .= '<tr><th>Título</th><th>Autor</th><th>Año</th><th>Género</th></tr>';
    
    foreach ($libros as $libro) {
        $html .= '<tr>';
        $html .= '<td>' . htmlspecialchars($libro[0]) . '</td>';
        $html .= '<td>' . htmlspecialchars($libro[1]) . '</td>';
        $html .= '<td>' . htmlspecialchars($libro[2]) . '</td>';
        $html .= '<td>' . htmlspecialchars($libro[3]) . '</td>';
        $html .= '</tr>';
    }
    
    $html .= '</table>';
    return $html;
}

// Código principal
$archivo = "libros.csv";

// ================= Apartado 3: Lectura de fichero y generación de tabla (2 puntos) ==========
$libros = cargarLibros($archivo);

// ================= Apartado 5: Filtro por género (1,5 puntos) ===============================
$genero_filtro = isset($_GET['genero']) ? $_GET['genero'] : 'Todos';
$generos_permitidos = ['Todos', 'Novela', 'Ciencia ficción', 'Fantasía'];
$genero_filtro = in_array($genero_filtro, $generos_permitidos) ? $genero_filtro : 'Todos';

// Aplicar filtro
if ($genero_filtro !== 'Todos') {
    $libros_filtrados = [];
    foreach ($libros as $libro) {
        if ($libro[3] === $genero_filtro) {
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
    if (isset($estadisticas_generos[$libro[3]])) {
        $estadisticas_generos[$libro[3]]++;
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
        <?= generarTablaLibros($libros_filtrados) ?>

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