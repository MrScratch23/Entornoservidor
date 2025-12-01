<?php
/*
    Página de gestión de equipo de héroes
    Autor: P.Lluyot
    Examen-2 de DWES - Curso 2025-2026
*/

session_start();
require_once "datos.php";

// función útil para eliminar héroe del array
function eliminarDelArray(&$array, $id_heroe) {
    foreach ($array as $key => $heroe) {
        if ($heroe['id'] === $id_heroe) {
            unset($array[$key]);
            return true;
        }
    }
    return false;
}

// Obtener todas las clases únicas disponibles (para estadísticas o filtros)
function obtenerClasesUnicas() {
    $clases = [];
    foreach (HEROES as $heroe) {
        $clase = $heroe['clase'];
        if (!in_array($clase, $clases)) {
            $clases[] = $clase;
        }
    }
    return $clases;
}

// Verificar si hay usuario en sesión
if (!isset($_SESSION['usuario'])) {
    header("Location: index.php");
    exit();
}

// Inicializar variables de sesión si no existen
if (!isset($_SESSION['equipo_heroes'])) {
    $_SESSION['equipo_heroes'] = [];
}

if (!isset($_SESSION['presupuesto_actual'])) {
    $_SESSION['presupuesto_actual'] = PRESUPUESTO_INICIAL;
}

if (!isset($_SESSION['totalEquipo'])) {
    $_SESSION['totalEquipo'] = 0;
}

// Obtener clases únicas para posibles usos futuros
$clasesUnicas = obtenerClasesUnicas();

$jugador = $_SESSION['usuario'];
$presupuesto = $_SESSION['presupuesto_actual'];
$equipoActual = $_SESSION['equipo_heroes'];
$arrayHeroes = HEROES;
$errores = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_heroe = $_POST['id_heroe'] ?? '';
    
    // Buscar el héroe por ID
    $heroeEncontrado = null;
    foreach ($arrayHeroes as $heroe) {
        if ($heroe['id'] === $id_heroe) {
            $heroeEncontrado = $heroe;
            break;
        }
    }
    
    if (isset($_POST['agregar'])) {
        if (!$heroeEncontrado) {
            $_SESSION['mensajeflash'] = "Error: Héroe no encontrado";
        } elseif ($heroeEncontrado['coste'] > $presupuesto) {
            $_SESSION['mensajeflash'] = "Error: No tienes suficiente presupuesto";
        } else {
            // Verificar si ya está en el equipo
            $enEquipo = false;
            foreach ($equipoActual as $heroeEquipo) {
                if ($heroeEquipo['id'] === $id_heroe) {
                    $enEquipo = true;
                    break;
                }
            }
            
            if ($enEquipo) {
                $_SESSION['mensajeflash'] = "Error: El héroe ya está en tu equipo";
            } else {
                // Añadir al equipo
                $_SESSION['equipo_heroes'][] = $heroeEncontrado;
                $_SESSION['presupuesto_actual'] -= $heroeEncontrado['coste'];
                $_SESSION['totalEquipo'] += $heroeEncontrado['coste'];
                $_SESSION['mensajeflash'] = "Héroe añadido correctamente al equipo";
                
                // Actualizar variables locales
                $presupuesto = $_SESSION['presupuesto_actual'];
                $equipoActual = $_SESSION['equipo_heroes'];
            }
        }
    }
    
    if (isset($_POST['eliminar'])) {
        if (!$heroeEncontrado) {
            $_SESSION['mensajeflash'] = "Error: Héroe no encontrado";
        } else {
            // Eliminar del equipo
            if (eliminarDelArray($_SESSION['equipo_heroes'], $id_heroe)) {
                $_SESSION['presupuesto_actual'] += $heroeEncontrado['coste'];
                $_SESSION['totalEquipo'] -= $heroeEncontrado['coste'];
                $_SESSION['mensajeflash'] = "Héroe eliminado del equipo";
                
                // Actualizar variables locales
                $presupuesto = $_SESSION['presupuesto_actual'];
                $equipoActual = $_SESSION['equipo_heroes'];
            } else {
                $_SESSION['mensajeflash'] = "Error: El héroe no está en tu equipo";
            }
        }
    }
    
    // Redirigir para evitar reenvío del formulario
    header("Location: equipo.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Equipo de Héroes</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-slate-100 text-slate-800">
    <div class="container mx-auto p-4 sm:p-6 lg:p-8">
        <!-- Cabecera con datos del jugador y acciones -->
        <header class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6">
            <div>
                <h1 class="text-3xl font-bold">Panel del Jugador: <span class="text-indigo-600"><?php echo htmlspecialchars($jugador) ?></span></h1>
                <p class="text-slate-500">Forma tu equipo gestionando tu presupuesto.</p>
            </div>

            <div class="flex flex-wrap gap-4 w-full sm:w-auto mt-4 sm:mt-0">
                <!-- Paneles de información rápida -->
                <div class="text-center bg-white shadow-md rounded-lg p-3 min-w-[160px]">
                    <span class="text-sm font-semibold text-slate-500">Presupuesto Restante</span>
                    <p class="text-2xl font-bold <?php echo $presupuesto < 100 ? 'text-red-600' : 'text-green-600'; ?>">
                        <?php echo number_format($presupuesto, 0, ',', '.') ?> Puntos
                    </p>
                </div>
                <div class="text-center bg-white shadow-md rounded-lg p-3">
                    <span class="text-sm font-semibold text-slate-500">Héroes</span>
                    <p class="text-2xl font-bold text-black-600">
                        <?php echo count($equipoActual); ?>
                    </p>
                </div>
                <div class="text-center bg-white shadow-md rounded-lg p-3">
                    <span class="text-sm font-semibold text-slate-500">Coste Total</span>
                    <p class="text-2xl font-bold text-indigo-600">
                        <?php echo number_format($_SESSION['totalEquipo'], 0, ',', '.'); ?> Puntos
                    </p>
                </div>
                <!-- Acciones principales -->
                <div class="flex flex-col gap-2">
                    <a href="analisis.php" class="text-center py-2 px-4 bg-blue-600 text-white font-semibold rounded-lg shadow-md hover:bg-blue-700 transition duration-200">
                        Ver Análisis
                    </a>
                    <a href="batalla.php" class="text-center py-2 px-4 bg-gradient-to-r from-red-600 to-yellow-600 text-white font-semibold rounded-lg shadow-md hover:from-red-700 hover:to-yellow-700 transition duration-200">
                        ⚔️ Ir a Batalla
                    </a>
                    <a href="reiniciar.php" class="text-center py-2 px-4 bg-red-600 text-white font-semibold rounded-lg shadow-md hover:bg-red-700 transition duration-200">
                        Reiniciar Juego
                    </a>
                </div>
            </div>
        </header>

        <!-- Sección de héroes reclutados y disponibles -->
        <section>
            <h2 class="text-2xl font-semibold border-b-2 border-slate-300 pb-2 mb-4">Lista de Héroes</h2>
            
            <!-- Mensajes flash -->
            <?php if (isset($_SESSION['mensajeflash'])): ?>
                <?php 
                $esError = stripos($_SESSION['mensajeflash'], 'error') !== false;
                $clase = $esError ? 'bg-red-100 border-red-500 text-red-700' : 'bg-blue-100 border-blue-500 text-blue-700';
                ?>
                <div class="<?php echo $clase; ?> border-l-4 p-4 mb-6 rounded-md" role="alert">
                    <p><?php echo htmlspecialchars($_SESSION['mensajeflash']); ?></p>
                </div>
                <?php unset($_SESSION['mensajeflash']); ?>
            <?php endif; ?>

            <!-- Estadísticas rápidas del equipo -->
            <div class="mb-6 grid grid-cols-2 md:grid-cols-4 gap-4">
                <div class="bg-white p-4 rounded-lg shadow">
                    <p class="text-sm text-slate-500">Presupuesto Inicial</p>
                    <p class="text-lg font-bold text-indigo-600"><?php echo number_format(PRESUPUESTO_INICIAL, 0, ',', '.'); ?></p>
                </div>
                <div class="bg-white p-4 rounded-lg shadow">
                    <p class="text-sm text-slate-500">Presupuesto Usado</p>
                    <p class="text-lg font-bold text-red-600"><?php echo number_format($_SESSION['totalEquipo'], 0, ',', '.'); ?></p>
                </div>
                <div class="bg-white p-4 rounded-lg shadow">
                    <p class="text-sm text-slate-500">Héroes Disponibles</p>
                    <p class="text-lg font-bold text-green-600"><?php echo count(HEROES); ?></p>
                </div>
                <div class="bg-white p-4 rounded-lg shadow">
                    <p class="text-sm text-slate-500">Clases Diferentes</p>
                    <p class="text-lg font-bold text-purple-600"><?php echo count($clasesUnicas); ?></p>
                </div>
            </div>

            <!-- Grid de héroes -->
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6 gap-4">
                <?php foreach ($arrayHeroes as $heroe): ?>
                    <?php
                    // Determinar si el héroe está en el equipo
                    $enEquipo = false;
                    foreach ($equipoActual as $heroeEquipo) {
                        if ($heroeEquipo['id'] === $heroe['id']) {
                            $enEquipo = true;
                            break;
                        }
                    }
                    
                    // Determinar si hay presupuesto suficiente
                    $sinPresupuesto = $heroe['coste'] > $presupuesto;
                    
                    // Determinar clases CSS
                    $claseTarjeta = 'rounded-lg shadow-xl overflow-hidden relative h-[420px] group transition-transform duration-300 hover:scale-[1.02]';
                    
                    if ($enEquipo) {
                        $claseTarjeta .= ' ring-4 ring-offset-2 ring-indigo-500 transform scale-[1.02]';
                    } elseif ($sinPresupuesto) {
                        $claseTarjeta .= ' opacity-70';
                    }
                    ?>
                    
                    <div class="<?php echo $claseTarjeta; ?>">
                        <img class="w-full h-full object-cover" src="img/<?php echo htmlspecialchars($heroe['imagen']); ?>" alt="<?php echo htmlspecialchars($heroe['nombre']); ?>">
                        <div class="absolute inset-0 p-3 flex flex-col justify-end text-white transition duration-300 ease-in-out">
                            <div class="p-2 rounded-lg bg-black/40 group-hover:bg-black/50 transition duration-300">
                                <div>
                                    <h3 class="text-xl font-extrabold border-b-2 border-indigo-400 pb-1 mb-1">
                                        <?php echo htmlspecialchars($heroe['nombre']); ?>
                                    </h3>
                                    <p class="text-base font-medium text-indigo-200 mb-2">
                                        <?php echo htmlspecialchars($heroe['clase']); ?>
                                    </p>
                                </div>
                                <div class="text-xs space-y-1 mb-3">
                                    <p><strong>Ataque: </strong><?php echo $heroe['ataque']; ?></p>
                                    <p><strong>Defensa: </strong><?php echo $heroe['defensa']; ?></p>
                                    <p><strong>Magia: </strong><?php echo $heroe['magia']; ?></p>
                                </div>
                                <p class="text-center font-bold text-indigo-300 text-lg mb-2">
                                    Coste: <?php echo number_format($heroe['coste'], 0, ',', '.'); ?>
                                </p>
                                <form method="post" action="equipo.php">
                                    <input type="hidden" name="id_heroe" value="<?php echo htmlspecialchars($heroe['id']); ?>">
                                    <?php if ($enEquipo): ?>
                                        <button type="submit" name="eliminar" class="w-full py-1 px-3 bg-red-600 text-white text-sm font-semibold rounded-lg shadow-md hover:bg-red-700 transition duration-150">
                                            Eliminar
                                        </button>
                                    <?php elseif ($sinPresupuesto): ?>
                                        <button type="button" disabled class="w-full py-1 px-3 bg-gray-400 text-white text-sm font-semibold rounded-lg shadow-md cursor-not-allowed">
                                            Sin presupuesto
                                        </button>
                                    <?php else: ?>
                                        <button type="submit" name="agregar" class="w-full py-1 px-3 text-white text-sm font-semibold rounded-lg shadow-md transition duration-150 bg-indigo-600 hover:bg-indigo-700">
                                            Reclutar
                                        </button>
                                    <?php endif; ?>
                                </form>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </section>
        
        <!-- Sección de tu equipo actual -->
        <section class="mt-12">
            <h2 class="text-2xl font-semibold border-b-2 border-slate-300 pb-2 mb-4">Tu Equipo Actual</h2>
            
            <?php if (empty($equipoActual)): ?>
                <div class="bg-yellow-50 border-l-4 border-yellow-500 text-yellow-700 p-6 rounded-md">
                    <p class="font-semibold">⚠️ No tienes héroes en tu equipo</p>
                    <p class="text-sm mt-2">Selecciona héroes de la lista superior para formar tu equipo.</p>
                </div>
            <?php else: ?>
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                    <?php foreach ($equipoActual as $heroe): ?>
                        <div class="bg-white rounded-lg shadow-lg p-4 border-2 border-indigo-300">
                            <div class="flex items-center mb-4">
                                <img src="img/<?php echo htmlspecialchars($heroe['imagen']); ?>" 
                                     alt="<?php echo htmlspecialchars($heroe['nombre']); ?>" 
                                     class="w-16 h-16 rounded-full object-cover mr-4 border-2 border-indigo-400">
                                <div>
                                    <h3 class="font-bold text-lg"><?php echo htmlspecialchars($heroe['nombre']); ?></h3>
                                    <p class="text-indigo-600"><?php echo htmlspecialchars($heroe['clase']); ?></p>
                                </div>
                            </div>
                            <div class="grid grid-cols-3 gap-2 mb-4">
                                <div class="text-center bg-red-50 p-2 rounded">
                                    <p class="text-xs text-red-500">ATK</p>
                                    <p class="font-bold"><?php echo $heroe['ataque']; ?></p>
                                </div>
                                <div class="text-center bg-blue-50 p-2 rounded">
                                    <p class="text-xs text-blue-500">DEF</p>
                                    <p class="font-bold"><?php echo $heroe['defensa']; ?></p>
                                </div>
                                <div class="text-center bg-purple-50 p-2 rounded">
                                    <p class="text-xs text-purple-500">MAG</p>
                                    <p class="font-bold"><?php echo $heroe['magia']; ?></p>
                                </div>
                            </div>
                            <div class="text-center">
                                <p class="text-sm text-slate-500">Coste:</p>
                                <p class="font-bold text-lg text-indigo-700"><?php echo number_format($heroe['coste'], 0, ',', '.'); ?></p>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
                
                <!-- Resumen del equipo -->
                <div class="mt-8 p-6 bg-gradient-to-r from-indigo-50 to-blue-50 rounded-lg border border-indigo-200">
                    <h3 class="text-lg font-bold text-indigo-800 mb-3">📊 Resumen de tu Equipo</h3>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                        <div>
                            <p class="text-sm text-indigo-600">Total de Héroes</p>
                            <p class="text-2xl font-bold"><?php echo count($equipoActual); ?></p>
                        </div>
                        <div>
                            <p class="text-sm text-indigo-600">Coste Promedio</p>
                            <p class="text-2xl font-bold">
                                <?php 
                                $promedio = count($equipoActual) > 0 ? $_SESSION['totalEquipo'] / count($equipoActual) : 0;
                                echo number_format($promedio, 0, ',', '.');
                                ?>
                            </p>
                        </div>
                        <div>
                            <p class="text-sm text-indigo-600">Espacio Restante</p>
                            <p class="text-2xl font-bold"><?php echo count(HEROES) - count($equipoActual); ?></p>
                        </div>
                        <div>
                            <p class="text-sm text-indigo-600">Listo para Batalla</p>
                            <p class="text-2xl font-bold <?php echo count($equipoActual) >= 3 ? 'text-green-600' : 'text-red-600'; ?>">
                                <?php echo count($equipoActual) >= 3 ? 'Sí' : 'No'; ?>
                            </p>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </section>
        
        <!-- Pie de página con autor y curso -->
        <footer class="text-center text-sm text-gray-500 mt-10 pt-6 border-t border-gray-200">
            © 2025 P.Lluyot · Examen de DWES
        </footer>
    </div>
</body>
</html>