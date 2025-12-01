<?php
/*
    Página de combate por turnos
    Autor: P.Lluyot
    Examen-2 de DWES - Curso 2025-2026
*/

session_start();

if (!isset($_SESSION['usuario']) || !isset($_SESSION['heroe_actual_jugador'])) {
    header("Location: batalla.php");
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

// Función para calcular daño
function calcularDaño($atacante, $defensor) {
    $ataqueBase = $atacante['ataque'];
    $defensaOponente = $defensor['defensa'];
    $magiaOponente = $defensor['magia'];
    
    // Daño base = ataque - (defensa/2)
    $daño = $ataqueBase - ($defensaOponente / 2);
    
    // La magia reduce el daño recibido (cada 10 puntos de magia reduce 1 de daño)
    $reduccionMagia = floor($magiaOponente / 10);
    $daño -= $reduccionMagia;
    
    // Daño mínimo de 1
    return max(1, floor($daño));
}

// Función para cambiar al siguiente héroe
function siguienteHeroe(&$equipo, &$heroeActual) {
    if (empty($equipo)) return null;
    
    $claveActual = array_search($heroeActual, $equipo);
    if ($claveActual === false) {
        return $equipo[0];
    }
    
    $siguienteClave = ($claveActual + 1) % count($equipo);
    return $equipo[$siguienteClave];
}

// Procesar ataque del jugador
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['atacar'])) {
        // Turno del jugador
        $daño = calcularDaño(
            $_SESSION['heroe_actual_jugador'],
            $_SESSION['heroe_actual_ia']
        );
        
        $_SESSION['vida_ia'] -= $daño;
        
        agregarLog("⚔️ " . $_SESSION['heroe_actual_jugador']['nombre'] . 
                  " ataca a " . $_SESSION['heroe_actual_ia']['nombre'] . 
                  " causando " . $daño . " puntos de daño!");
        
        // Verificar si la IA perdió
        if ($_SESSION['vida_ia'] <= 0) {
            $_SESSION['vida_ia'] = 0;
            agregarLog("🎉 ¡VICTORIA! Has derrotado a la IA.");
            header("Location: resultado.php");
            exit();
        }
        
        // Turno de la IA
        $dañoIA = calcularDaño(
            $_SESSION['heroe_actual_ia'],
            $_SESSION['heroe_actual_jugador']
        );
        
        $_SESSION['vida_jugador'] -= $dañoIA;
        
        agregarLog("🤖 " . $_SESSION['heroe_actual_ia']['nombre'] . 
                  " contraataca causando " . $dañoIA . " puntos de daño!");
        
        // Verificar si el jugador perdió
        if ($_SESSION['vida_jugador'] <= 0) {
            $_SESSION['vida_jugador'] = 0;
            agregarLog("💀 Derrota... La IA te ha vencido.");
            header("Location: resultado.php");
            exit();
        }
        
        // Cambiar héroes para la siguiente ronda
        $_SESSION['heroe_actual_jugador'] = siguienteHeroe(
            $_SESSION['heroes_disponibles_jugador'],
            $_SESSION['heroe_actual_jugador']
        );
        
        $_SESSION['heroe_actual_ia'] = siguienteHeroe(
            $_SESSION['heroes_disponibles_ia'],
            $_SESSION['heroe_actual_ia']
        );
        
        $_SESSION['ronda_actual']++;
        
        // Redirigir para evitar reenvío del formulario
        header("Location: combate.php");
        exit();
    }
    
    if (isset($_POST['rendirse'])) {
        agregarLog("🏳️ " . $_SESSION['usuario'] . " se ha rendido.");
        $_SESSION['vida_jugador'] = 0;
        header("Location: resultado.php");
        exit();
    }
    
    if (isset($_POST['volver'])) {
        header("Location: batalla.php");
        exit();
    }
}

// Función para crear barra de vida
function crearBarraVida($vida, $color) {
    $porcentaje = min(100, max(0, $vida));
    return '
    <div class="w-full bg-gray-700 rounded-full h-6">
        <div class="' . $color . ' h-6 rounded-full transition-all duration-500" 
             style="width: ' . $porcentaje . '%">
            <div class="text-center text-white font-bold text-sm leading-6">
                ' . $vida . ' HP
            </div>
        </div>
    </div>';
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Combate en Curso</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-900 text-white">
    <div class="container mx-auto p-4">
        <!-- Cabecera -->
        <header class="mb-6">
            <div class="flex justify-between items-center">
                <div>
                    <h1 class="text-3xl font-bold text-yellow-400">⚔️ Ronda <?php echo $_SESSION['ronda_actual']; ?></h1>
                    <p class="text-gray-300">Combate en curso</p>
                </div>
                <form method="post" class="flex gap-2">
                    <button type="submit" name="volver" 
                            class="py-2 px-4 bg-gray-700 text-white rounded-lg hover:bg-gray-600">
                        ↩️ Volver
                    </button>
                    <button type="submit" name="rendirse"
                            onclick="return confirm('¿Estás seguro de que quieres rendirte?')"
                            class="py-2 px-4 bg-red-700 text-white rounded-lg hover:bg-red-600">
                        🏳️ Rendirse
                    </button>
                </form>
            </div>
        </header>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Panel Jugador -->
            <div class="bg-gradient-to-b from-blue-900 to-gray-800 rounded-xl p-6 shadow-2xl">
                <h2 class="text-2xl font-bold text-blue-300 mb-4">🛡️ Tu Héroe</h2>
                
                <?php if ($_SESSION['heroe_actual_jugador']): ?>
                <?php $heroeJugador = $_SESSION['heroe_actual_jugador']; ?>
                <div class="text-center mb-6">
                    <img src="img/<?php echo $heroeJugador['imagen']; ?>" 
                         alt="<?php echo $heroeJugador['nombre']; ?>" 
                         class="w-48 h-48 mx-auto rounded-full border-4 border-blue-500 object-cover mb-4">
                    <h3 class="text-2xl font-bold"><?php echo $heroeJugador['nombre']; ?></h3>
                    <p class="text-lg text-blue-300"><?php echo $heroeJugador['clase']; ?></p>
                </div>
                
                <div class="space-y-3 mb-6">
                    <div class="bg-blue-800 p-3 rounded-lg">
                        <p class="font-bold">⚔️ Ataque: <span class="text-red-300"><?php echo $heroeJugador['ataque']; ?></span></p>
                    </div>
                    <div class="bg-blue-800 p-3 rounded-lg">
                        <p class="font-bold">🛡️ Defensa: <span class="text-blue-300"><?php echo $heroeJugador['defensa']; ?></span></p>
                    </div>
                    <div class="bg-blue-800 p-3 rounded-lg">
                        <p class="font-bold">✨ Magia: <span class="text-purple-300"><?php echo $heroeJugador['magia']; ?></span></p>
                    </div>
                </div>
                <?php endif; ?>
                
                <!-- Barra de vida jugador -->
                <div class="mb-4">
                    <p class="font-bold mb-2">Vida: <?php echo $_SESSION['vida_jugador']; ?> ❤️</p>
                    <?php echo crearBarraVida($_SESSION['vida_jugador'], 'bg-gradient-to-r from-green-500 to-green-700'); ?>
                </div>
                
                <form method="post">
                    <button type="submit" name="atacar"
                            class="w-full py-4 bg-gradient-to-r from-red-600 to-red-800 text-white font-bold text-xl rounded-lg hover:from-red-700 hover:to-red-900 transition-all duration-300">
                        ⚔️ ATACAR
                    </button>
                </form>
            </div>

            <!-- Panel Central - Log de Batalla -->
            <div class="bg-gray-800 rounded-xl p-6 shadow-2xl">
                <h2 class="text-2xl font-bold text-yellow-300 mb-4">📜 Log de Batalla</h2>
                <div class="h-[500px] overflow-y-auto bg-gray-900 rounded-lg p-4">
                    <?php if (!empty($_SESSION['log_batalla'])): ?>
                        <?php foreach (array_reverse($_SESSION['log_batalla']) as $log): ?>
                            <div class="mb-3 p-3 bg-gray-700 rounded-lg border-l-4 border-yellow-500">
                                <div class="flex justify-between text-sm text-gray-400 mb-1">
                                    <span>Ronda <?php echo $log['ronda']; ?></span>
                                    <span><?php echo $log['timestamp']; ?></span>
                                </div>
                                <p class="text-white"><?php echo $log['mensaje']; ?></p>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p class="text-center text-gray-500 italic">La batalla aún no ha comenzado...</p>
                    <?php endif; ?>
                </div>
                
                <!-- Estadísticas rápidas -->
                <div class="mt-6 grid grid-cols-2 gap-4">
                    <div class="bg-gray-700 p-3 rounded-lg text-center">
                        <p class="text-sm text-gray-300">Héroes Restantes</p>
                        <p class="text-xl font-bold text-blue-300">
                            <?php echo count($_SESSION['heroes_disponibles_jugador'] ?? []); ?>
                        </p>
                    </div>
                    <div class="bg-gray-700 p-3 rounded-lg text-center">
                        <p class="text-sm text-gray-300">Héroes IA</p>
                        <p class="text-xl font-bold text-red-300">
                            <?php echo count($_SESSION['heroes_disponibles_ia'] ?? []); ?>
                        </p>
                    </div>
                </div>
            </div>

            <!-- Panel IA -->
            <div class="bg-gradient-to-b from-red-900 to-gray-800 rounded-xl p-6 shadow-2xl">
                <h2 class="text-2xl font-bold text-red-300 mb-4">🤖 Héroe IA</h2>
                
                <?php if ($_SESSION['heroe_actual_ia']): ?>
                <?php $heroeIA = $_SESSION['heroe_actual_ia']; ?>
                <div class="text-center mb-6">
                    <img src="img/<?php echo $heroeIA['imagen']; ?>" 
                         alt="<?php echo $heroeIA['nombre']; ?>" 
                         class="w-48 h-48 mx-auto rounded-full border-4 border-red-500 object-cover mb-4">
                    <h3 class="text-2xl font-bold"><?php echo $heroeIA['nombre']; ?></h3>
                    <p class="text-lg text-red-300"><?php echo $heroeIA['clase']; ?></p>
                </div>
                
                <div class="space-y-3 mb-6">
                    <div class="bg-red-800 p-3 rounded-lg">
                        <p class="font-bold">⚔️ Ataque: <span class="text-red-300"><?php echo $heroeIA['ataque']; ?></span></p>
                    </div>
                    <div class="bg-red-800 p-3 rounded-lg">
                        <p class="font-bold">🛡️ Defensa: <span class="text-blue-300"><?php echo $heroeIA['defensa']; ?></span></p>
                    </div>
                    <div class="bg-red-800 p-3 rounded-lg">
                        <p class="font-bold">✨ Magia: <span class="text-purple-300"><?php echo $heroeIA['magia']; ?></span></p>
                    </div>
                </div>
                <?php endif; ?>
                
                <!-- Barra de vida IA -->
                <div class="mb-4">
                    <p class="font-bold mb-2">Vida IA: <?php echo $_SESSION['vida_ia']; ?> ❤️</p>
                    <?php echo crearBarraVida($_SESSION['vida_ia'], 'bg-gradient-to-r from-red-500 to-red-700'); ?>
                </div>
                
                <div class="text-center py-4 bg-red-800 rounded-lg">
                    <p class="font-bold text-lg">🤖 Turno de la IA</p>
                    <p class="text-sm text-gray-300">La IA atacará después de tu turno</p>
                </div>
            </div>
        </div>

        <!-- Próximos héroes -->
        <div class="mt-8 bg-gray-800 rounded-xl p-6">
            <h3 class="text-xl font-bold text-yellow-300 mb-4">🔮 Próximos Héroes en Turno</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div>
                    <h4 class="text-lg font-bold text-blue-300 mb-3">Tu Próximo Héroe</h4>
                    <?php 
                    $proximoJugador = siguienteHeroe(
                        $_SESSION['heroes_disponibles_jugador'],
                        $_SESSION['heroe_actual_jugador']
                    );
                    ?>
                    <?php if ($proximoJugador): ?>
                    <div class="flex items-center bg-blue-900 p-4 rounded-lg">
                        <img src="img/<?php echo $proximoJugador['imagen']; ?>" 
                             alt="<?php echo $proximoJugador['nombre']; ?>" 
                             class="w-16 h-16 rounded-full mr-4 object-cover">
                        <div>
                            <p class="font-bold"><?php echo $proximoJugador['nombre']; ?></p>
                            <p class="text-sm text-blue-300"><?php echo $proximoJugador['clase']; ?></p>
                            <div class="flex gap-2 mt-1">
                                <span class="text-xs bg-red-900 px-2 rounded">⚔️ <?php echo $proximoJugador['ataque']; ?></span>
                                <span class="text-xs bg-blue-900 px-2 rounded">🛡️ <?php echo $proximoJugador['defensa']; ?></span>
                            </div>
                        </div>
                    </div>
                    <?php endif; ?>
                </div>
                
                <div>
                    <h4 class="text-lg font-bold text-red-300 mb-3">Próximo Héroe IA</h4>
                    <?php 
                    $proximoIA = siguienteHeroe(
                        $_SESSION['heroes_disponibles_ia'],
                        $_SESSION['heroe_actual_ia']
                    );
                    ?>
                    <?php if ($proximoIA): ?>
                    <div class="flex items-center bg-red-900 p-4 rounded-lg opacity-80">
                        <img src="img/<?php echo $proximoIA['imagen']; ?>" 
                             alt="<?php echo $proximoIA['nombre']; ?>" 
                             class="w-16 h-16 rounded-full mr-4 object-cover">
                        <div>
                            <p class="font-bold"><?php echo $proximoIA['nombre']; ?></p>
                            <p class="text-sm text-red-300"><?php echo $proximoIA['clase']; ?></p>
                            <div class="flex gap-2 mt-1">
                                <span class="text-xs bg-red-900 px-2 rounded">⚔️ <?php echo $proximoIA['ataque']; ?></span>
                                <span class="text-xs bg-blue-900 px-2 rounded">🛡️ <?php echo $proximoIA['defensa']; ?></span>
                            </div>
                        </div>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</body>
</html>