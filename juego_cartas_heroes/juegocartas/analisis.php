<?php
/*
    Página de análisis del equipo de héroes
    Autor: P.Lluyot
    Examen-2 de DWES - Curso 2025-2026
*/

session_start();
require_once "datos.php";

if (!isset($_SESSION['usuario'])) {
    header("Location: index.php");
    exit();
}

$heroes = $_SESSION['equipo_heroes'] ?? [];
$usuario = $_SESSION['usuario'];

// Inicializar variables para estadísticas
$costeTotal = 0;
$ataqueTotal = 0;
$magiaTotal = 0;
$defensaTotal = 0;
$totalHeroes = count($heroes);

// Obtener todas las clases únicas disponibles de los héroes del sistema
$todasLasClases = [];
foreach (HEROES as $heroe) {
    $clase = $heroe['clase'];
    if (!in_array($clase, $todasLasClases)) {
        $todasLasClases[] = $clase;
    }
}

// Inicializar contador de clases dinámicamente
$clases = array_fill_keys($todasLasClases, 0);

// Calcular totales y contar clases
foreach ($heroes as $heroe) {
    $costeTotal += $heroe['coste'];
    $ataqueTotal += $heroe['ataque'];
    $magiaTotal += $heroe['magia'];
    $defensaTotal += $heroe['defensa'];
    
    // Contar por clase
    if (isset($clases[$heroe['clase']])) {
        $clases[$heroe['clase']]++;
    }
}

// Calcular promedios (solo si hay héroes)
$ataquePromedio = $totalHeroes > 0 ? $ataqueTotal / $totalHeroes : 0;
$defensaPromedio = $totalHeroes > 0 ? $defensaTotal / $totalHeroes : 0;
$magiaPromedio = $totalHeroes > 0 ? $magiaTotal / $totalHeroes : 0;
$costePromedio = $totalHeroes > 0 ? $costeTotal / $totalHeroes : 0;

// Guardar en sesión si es necesario para otras páginas
$_SESSION['costeTotal'] = $costeTotal;
$_SESSION['ataqueTotal'] = $ataqueTotal;
$_SESSION['magiaTotal'] = $magiaTotal;
$_SESSION['defensaTotal'] = $defensaTotal;
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Análisis del Equipo</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-slate-100 text-slate-800">
    <div class="container mx-auto p-4 sm:p-6 lg:p-8">
        <!-- Cabecera y botón volver -->
        <header class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6">
            <div class="mb-4 sm:mb-0">
                <h1 class="text-3xl font-bold">Análisis del Equipo</h1>
                <p class="text-slate-500">Resumen y estadísticas del equipo formado por 
                    <span class="font-semibold text-indigo-600"><?php echo htmlspecialchars($usuario); ?></span>
                </p>
            </div>
            <div class="flex flex-col sm:flex-row gap-2">
                <a href="equipo.php" class="py-2 px-4 bg-indigo-600 text-white font-semibold rounded-lg shadow-md hover:bg-indigo-700 transition duration-200 text-center">
                    Volver a la Gestión
                </a>
                <a href="reiniciar.php" class="py-2 px-4 bg-red-600 text-white font-semibold rounded-lg shadow-md hover:bg-red-700 transition duration-200 text-center">
                    Reiniciar Juego
                </a>
            </div>
        </header>

        <!-- SECCIÓN: EQUIPO FINAL -->
        <section class="mb-10">
            <h2 class="text-2xl font-semibold border-b-2 border-slate-300 pb-2 mb-4">Composición del Equipo Final</h2>
            
            <?php if ($totalHeroes === 0): ?>
                <!-- Mensaje si el equipo está vacío -->
                <div class="col-span-full bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded-md" role="alert">
                    <p class="font-semibold">No hay héroes en el equipo. ¡Ve a la página de gestión para reclutar héroes!</p>
                </div>
            <?php else: ?>
                <!-- Grid de héroes -->
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-6 gap-4">
                    <?php foreach ($heroes as $heroe): ?>
                    <div class="rounded-lg shadow-lg overflow-hidden relative group ring-4 ring-offset-1 ring-indigo-500">
                        <img class="w-full h-full object-cover" src="img/<?php echo htmlspecialchars($heroe['imagen']); ?>" 
                             alt="<?php echo htmlspecialchars($heroe['nombre']); ?>">
                        <div class="absolute inset-0 p-3 flex flex-col justify-end text-white transition duration-300 ease-in-out">
                            <div class="p-4 bg-black/40 transition duration-300 group-hover:bg-black/50 rounded-lg">
                                <h3 class="text-xl font-extrabold border-b-2 border-indigo-400 pb-1 mb-1">
                                    <?php echo htmlspecialchars($heroe['nombre']); ?>
                                </h3>
                                <p class="text-base font-medium text-indigo-200 mb-2">
                                    <?php echo htmlspecialchars($heroe['clase']); ?>
                                </p>
                                <div class="text-xs space-y-1">
                                    <p><strong>Ataque:</strong> <?php echo $heroe['ataque']; ?></p>
                                    <p><strong>Defensa:</strong> <?php echo $heroe['defensa']; ?></p>
                                    <p><strong>Magia:</strong> <?php echo $heroe['magia']; ?></p>
                                    <p class="mt-2"><strong>Coste:</strong> <?php echo number_format($heroe['coste'], 0, ',', '.'); ?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </section>

        <!-- SECCIÓN: ESTADÍSTICAS GLOBALES (solo si hay héroes) -->
        <?php if ($totalHeroes > 0): ?>
        <section>
            <h2 class="text-2xl font-semibold border-b-2 border-slate-300 pb-2 mb-4">Estadísticas Globales</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- Tarjeta de Coste Total -->
                <div class="bg-white p-6 rounded-lg shadow-lg text-center">
                    <h3 class="text-sm font-semibold text-slate-500 uppercase">Coste Total del Equipo</h3>
                    <p class="text-4xl font-bold text-indigo-600 mt-2">
                        <?php echo number_format($costeTotal, 0, ',', '.'); ?>
                    </p>
                    <p class="text-sm text-slate-500 mt-2">
                        <?php echo number_format($costePromedio, 1, ',', '.'); ?> por héroe
                    </p>
                </div>
                
                <!-- Tarjeta de Estadísticas Totales -->
                <div class="bg-white p-6 rounded-lg shadow-lg text-center">
                    <h3 class="text-sm font-semibold text-slate-500 uppercase">Ataque / Defensa / Magia Total</h3>
                    <div class="mt-4 space-y-3">
                        <div>
                            <p class="text-sm text-slate-500">Ataque Total</p>
                            <p class="text-2xl font-bold text-red-600"><?php echo number_format($ataqueTotal, 0, ',', '.'); ?></p>
                        </div>
                        <div>
                            <p class="text-sm text-slate-500">Defensa Total</p>
                            <p class="text-2xl font-bold text-blue-600"><?php echo number_format($defensaTotal, 0, ',', '.'); ?></p>
                        </div>
                        <div>
                            <p class="text-sm text-slate-500">Magia Total</p>
                            <p class="text-2xl font-bold text-purple-600"><?php echo number_format($magiaTotal, 0, ',', '.'); ?></p>
                        </div>
                    </div>
                </div>
                
                <!-- Tarjeta de Promedios -->
                <div class="bg-white p-6 rounded-lg shadow-lg text-center">
                    <h3 class="text-sm font-semibold text-slate-500 uppercase">Promedio por Miembro</h3>
                    <div class="mt-4 space-y-3">
                        <div>
                            <p class="text-sm text-slate-500">Ataque Promedio</p>
                            <p class="text-2xl font-bold text-red-600"><?php echo number_format($ataquePromedio, 1, ',', '.'); ?></p>
                        </div>
                        <div>
                            <p class="text-sm text-slate-500">Defensa Promedio</p>
                            <p class="text-2xl font-bold text-blue-600"><?php echo number_format($defensaPromedio, 1, ',', '.'); ?></p>
                        </div>
                        <div>
                            <p class="text-sm text-slate-500">Magia Promedio</p>
                            <p class="text-2xl font-bold text-purple-600"><?php echo number_format($magiaPromedio, 1, ',', '.'); ?></p>
                        </div>
                    </div>
                </div>
                
                <!-- Tarjeta de Recuento por Clase -->
                <div class="bg-white p-6 rounded-lg shadow-lg">
                    <h3 class="text-sm font-semibold text-slate-500 uppercase text-center mb-3">Recuento por Clase</h3>
                    <div class="space-y-3">
                        <?php foreach ($clases as $clase => $cantidad): ?>
                            <?php if ($cantidad > 0): ?>
                                <div class="flex justify-between items-center p-2 bg-slate-50 rounded">
                                    <span class="font-semibold"><?php echo htmlspecialchars($clase); ?></span>
                                    <span class="font-bold text-indigo-600 text-lg"><?php echo $cantidad; ?></span>
                                </div>
                            <?php endif; ?>
                        <?php endforeach; ?>
                        
                        <!-- Mostrar mensaje si no hay héroes de cierta clase -->
                        <?php if (array_sum($clases) === 0): ?>
                            <p class="text-center text-slate-500 italic">No hay héroes en el equipo</p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            
            <!-- Información adicional -->
            <div class="mt-8 p-6 bg-indigo-50 rounded-lg">
                <h3 class="text-lg font-semibold text-indigo-800 mb-3">Resumen del Equipo</h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="text-center">
                        <p class="text-sm text-indigo-600">Total de Héroes</p>
                        <p class="text-2xl font-bold text-indigo-800"><?php echo $totalHeroes; ?></p>
                    </div>
                    <div class="text-center">
                        <p class="text-sm text-indigo-600">Presupuesto Usado</p>
                        <p class="text-2xl font-bold text-indigo-800">
                            <?php echo number_format($costeTotal, 0, ',', '.'); ?> / <?php echo number_format(PRESUPUESTO_INICIAL, 0, ',', '.'); ?>
                        </p>
                    </div>
                    <div class="text-center">
                        <p class="text-sm text-indigo-600">Presupuesto Restante</p>
                        <p class="text-2xl font-bold text-indigo-800">
                            <?php echo number_format(PRESUPUESTO_INICIAL - $costeTotal, 0, ',', '.'); ?>
                        </p>
                    </div>
                </div>
            </div>
        </section>
        <?php endif; ?>
        
        <!-- Pie de página -->
        <footer class="text-center text-sm text-gray-500 mt-10 pt-6 border-t border-gray-200">
            © 2025 P.Lluyot · Examen de DWES
        </footer>
    </div>
</body>
</html>