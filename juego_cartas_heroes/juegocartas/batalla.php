<?php
/*
    Página de batalla - Menú principal
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
$totalHeroes = count($heroes);

// Inicializar vida si no existe
if (!isset($_SESSION['vida_jugador'])) {
    $_SESSION['vida_jugador'] = 100;
    $_SESSION['vida_ia'] = 100;
    $_SESSION['ronda_actual'] = 1;
    $_SESSION['log_batalla'] = [];
    $_SESSION['heroe_actual_jugador'] = null;
    $_SESSION['heroe_actual_ia'] = null;
}

// Si no hay héroes, mostrar error
if ($totalHeroes === 0) {
    $_SESSION['mensajeflash'] = "¡Necesitas reclutar héroes antes de entrar en batalla!";
    header("Location: equipo.php");
    exit();
}

// Si el equipo de la IA no está creado, crearlo
if (!isset($_SESSION['equipo_ia']) || empty($_SESSION['equipo_ia'])) {
    crearEquipoIA();
}

// Función para crear equipo IA
function crearEquipoIA() {
    global $heroes;
    $todasLasClases = [];
    
    // Obtener todas las clases únicas
    foreach (HEROES as $heroe) {
        $clase = $heroe['clase'];
        if (!in_array($clase, $todasLasClases)) {
            $todasLasClases[] = $clase;
        }
    }
    
    // Seleccionar un héroe aleatorio de cada clase (máximo 1 por clase)
    $equipoIA = [];
    $presupuestoIA = PRESUPUESTO_INICIAL;
    
    shuffle($todasLasClases);
    
    foreach ($todasLasClases as $clase) {
        // Filtrar héroes por clase
        $heroesClase = array_filter(HEROES, function($h) use ($clase) {
            return $h['clase'] === $clase;
        });
        
        if (!empty($heroesClase)) {
            $heroeAleatorio = $heroesClase[array_rand($heroesClase)];
            
            if ($presupuestoIA >= $heroeAleatorio['coste']) {
                $equipoIA[] = $heroeAleatorio;
                $presupuestoIA -= $heroeAleatorio['coste'];
            }
        }
        
        // Máximo 6 héroes para la IA
        if (count($equipoIA) >= 6) break;
    }
    
    $_SESSION['equipo_ia'] = $equipoIA;
    $_SESSION['heroes_disponibles_ia'] = $equipoIA; // Copia para control de turnos
}

// Procesar inicio de batalla
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['iniciar_batalla'])) {
    $_SESSION['vida_jugador'] = 100;
    $_SESSION['vida_ia'] = 100;
    $_SESSION['ronda_actual'] = 1;
    $_SESSION['log_batalla'] = [];
    $_SESSION['heroes_disponibles_jugador'] = $heroes;
    $_SESSION['heroes_disponibles_ia'] = $_SESSION['equipo_ia'];
    
    // Seleccionar primer héroe para jugador
    $_SESSION['heroe_actual_jugador'] = $_SESSION['heroes_disponibles_jugador'][0] ?? null;
    
    // Seleccionar primer héroe para IA
    $_SESSION['heroe_actual_ia'] = $_SESSION['heroes_disponibles_ia'][0] ?? null;
    
    // Añadir al log
    agregarLog("¡La batalla ha comenzado!");
    agregarLog("Jugador: " . $_SESSION['usuario'] . " vs IA");
    
    header("Location: combate.php");
    exit();
}

// Función para agregar mensajes al log
function agregarLog($mensaje) {
    $_SESSION['log_batalla'][] = [
        'ronda' => $_SESSION['ronda_actual'] ?? 1,
        'mensaje' => $mensaje,
        'timestamp' => date('H:i:s')
    ];
    
    // Mantener solo los últimos 20 mensajes
    if (count($_SESSION['log_batalla']) > 20) {
        array_shift($_SESSION['log_batalla']);
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Batalla Épica</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-900 text-white">
    <div class="container mx-auto p-4 sm:p-6 lg:p-8">
        <!-- Cabecera -->
        <header class="mb-8">
            <div class="flex justify-between items-center">
                <div>
                    <h1 class="text-4xl font-bold text-yellow-400">⚔️ Batalla Épica</h1>
                    <p class="text-gray-300">Prepara tu equipo para el combate</p>
                </div>
                <div class="flex gap-2">
                    <a href="equipo.php" class="py-2 px-4 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700">
                        Volver al Equipo
                    </a>
                    <a href="reiniciar.php" class="py-2 px-4 bg-red-600 text-white font-semibold rounded-lg hover:bg-red-700">
                        Reiniciar
                    </a>
                </div>
            </div>
        </header>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Panel Jugador -->
            <div class="bg-gray-800 rounded-xl p-6 shadow-2xl">
                <h2 class="text-2xl font-bold text-blue-400 mb-4 border-b border-blue-700 pb-2">
                    🛡️ Tu Equipo
                </h2>
                <div class="mb-4">
                    <p class="text-lg">Jugador: <span class="font-bold text-yellow-300"><?php echo htmlspecialchars($_SESSION['usuario']); ?></span></p>
                    <p class="text-lg">Vida: <span class="font-bold text-green-400"><?php echo $_SESSION['vida_jugador']; ?> ❤️</span></p>
                    <p class="text-lg">Héroes: <span class="font-bold text-blue-300"><?php echo $totalHeroes; ?></span></p>
                </div>
                
                <div class="grid grid-cols-2 gap-4 mb-6">
                    <?php foreach ($heroes as $index => $heroe): ?>
                        <div class="bg-gray-700 rounded-lg p-3 border border-blue-500">
                            <div class="flex items-center">
                                <img src="img/<?php echo $heroe['imagen']; ?>" 
                                     alt="<?php echo $heroe['nombre']; ?>" 
                                     class="w-12 h-12 rounded-full mr-3 object-cover">
                                <div>
                                    <p class="font-bold"><?php echo $heroe['nombre']; ?></p>
                                    <p class="text-sm text-gray-300"><?php echo $heroe['clase']; ?></p>
                                </div>
                            </div>
                            <div class="mt-2 text-sm grid grid-cols-3 gap-1">
                                <span class="bg-red-900 text-center rounded">⚔️ <?php echo $heroe['ataque']; ?></span>
                                <span class="bg-blue-900 text-center rounded">🛡️ <?php echo $heroe['defensa']; ?></span>
                                <span class="bg-purple-900 text-center rounded">✨ <?php echo $heroe['magia']; ?></span>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
                
                <form method="post" class="mt-4">
                    <button type="submit" name="iniciar_batalla" 
                            class="w-full py-3 bg-gradient-to-r from-red-700 to-red-900 text-white font-bold text-xl rounded-lg hover:from-red-800 hover:to-red-950 transition-all duration-300">
                        🚀 INICIAR BATALLA
                    </button>
                </form>
            </div>

            <!-- Panel IA -->
            <div class="bg-gray-800 rounded-xl p-6 shadow-2xl">
                <h2 class="text-2xl font-bold text-red-400 mb-4 border-b border-red-700 pb-2">
                    🤖 Equipo de la IA
                </h2>
                <div class="mb-4">
                    <p class="text-lg">Oponente: <span class="font-bold text-red-300">Máquina de Guerra</span></p>
                    <p class="text-lg">Vida: <span class="font-bold text-green-400"><?php echo $_SESSION['vida_ia']; ?> ❤️</span></p>
                    <p class="text-lg">Héroes: <span class="font-bold text-red-300"><?php echo count($_SESSION['equipo_ia'] ?? []); ?></span></p>
                </div>
                
                <div class="grid grid-cols-2 gap-4">
                    <?php if (isset($_SESSION['equipo_ia'])): ?>
                        <?php foreach ($_SESSION['equipo_ia'] as $heroe): ?>
                            <div class="bg-gray-700 rounded-lg p-3 border border-red-500 opacity-80">
                                <div class="flex items-center">
                                    <img src="img/<?php echo $heroe['imagen']; ?>" 
                                         alt="<?php echo $heroe['nombre']; ?>" 
                                         class="w-12 h-12 rounded-full mr-3 object-cover">
                                    <div>
                                        <p class="font-bold"><?php echo $heroe['nombre']; ?></p>
                                        <p class="text-sm text-gray-300"><?php echo $heroe['clase']; ?></p>
                                    </div>
                                </div>
                                <div class="mt-2 text-sm grid grid-cols-3 gap-1">
                                    <span class="bg-red-900 text-center rounded">⚔️ <?php echo $heroe['ataque']; ?></span>
                                    <span class="bg-blue-900 text-center rounded">🛡️ <?php echo $heroe['defensa']; ?></span>
                                    <span class="bg-purple-900 text-center rounded">✨ <?php echo $heroe['magia']; ?></span>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Reglas del juego -->
        <div class="mt-8 bg-gray-800 rounded-xl p-6">
            <h3 class="text-xl font-bold text-yellow-300 mb-4">📜 Reglas de la Batalla</h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="bg-gray-700 p-4 rounded-lg">
                    <h4 class="font-bold text-green-400 mb-2">🎯 Sistema de Combate</h4>
                    <ul class="text-sm text-gray-300 space-y-1">
                        <li>• Turnos alternos por ronda</li>
                        <li>• Cada héroe tiene ATK, DEF y MAG</li>
                        <li>• Daño = ATQ - (DEF oponente / 2)</li>
                        <li>• Magia reduce daño recibido</li>
                    </ul>
                </div>
                <div class="bg-gray-700 p-4 rounded-lg">
                    <h4 class="font-bold text-blue-400 mb-2">🔄 Mecánicas</h4>
                    <ul class="text-sm text-gray-300 space-y-1">
                        <li>• Vida inicial: 100 puntos cada uno</li>
                        <li>• Se juega hasta que alguien llegue a 0</li>
                        <li>• Los héroes caídos no vuelven</li>
                        <li>• Rotación automática de héroes</li>
                    </ul>
                </div>
                <div class="bg-gray-700 p-4 rounded-lg">
                    <h4 class="font-bold text-purple-400 mb-2">🏆 Estrategias</h4>
                    <ul class="text-sm text-gray-300 space-y-1">
                        <li>• Combina diferentes clases</li>
                        <li>• Usa defensores contra atacantes</li>
                        <li>• Magos son débiles físicamente</li>
                        <li>• ¡Planifica tu orden de batalla!</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</body>
</html>