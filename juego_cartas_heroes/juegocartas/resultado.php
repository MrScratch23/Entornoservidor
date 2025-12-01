<?php
/*
    Página de resultado de batalla
    Autor: P.Lluyot
    Examen-2 de DWES - Curso 2025-2026
*/

session_start();

if (!isset($_SESSION['usuario'])) {
    header("Location: index.php");
    exit();
}

$ganador = $_SESSION['vida_jugador'] > $_SESSION['vida_ia'] ? 'jugador' : 'ia';
$victoria = $ganador === 'jugador';
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resultado de la Batalla</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-b from-gray-900 to-black text-white">
    <div class="container mx-auto p-8 text-center">
        
        <?php if ($victoria): ?>
            <!-- Victoria -->
            <div class="animate-pulse">
                <h1 class="text-6xl font-bold text-yellow-400 mb-4">🏆 ¡VICTORIA!</h1>
                <div class="text-4xl mb-6">
                    <?php for($i = 0; $i < 5; $i++): ?>⭐<?php endfor; ?>
                </div>
                <p class="text-2xl text-green-400 mb-8">
                    ¡Has derrotado a la IA en <?php echo $_SESSION['ronda_actual']; ?> rondas!
                </p>
            </div>
        <?php else: ?>
            <!-- Derrota -->
            <div class="animate-bounce">
                <h1 class="text-6xl font-bold text-red-400 mb-4">💀 DERROTA</h1>
                <div class="text-4xl mb-6">☠️</div>
                <p class="text-2xl text-red-300 mb-8">
                    La IA te ha vencido en <?php echo $_SESSION['ronda_actual']; ?> rondas...
                </p>
            </div>
        <?php endif; ?>

        <!-- Estadísticas finales -->
        <div class="max-w-2xl mx-auto bg-gray-800 rounded-xl p-8 mb-8">
            <h2 class="text-3xl font-bold mb-6">📊 Estadísticas Finales</h2>
            
            <div class="grid grid-cols-2 gap-8">
                <div class="text-left">
                    <h3 class="text-xl font-bold text-blue-400 mb-4">Tu Equipo</h3>
                    <div class="space-y-2">
                        <p><span class="font-bold">Jugador:</span> <?php echo htmlspecialchars($_SESSION['usuario']); ?></p>
                        <p><span class="font-bold">Vida Final:</span> <span class="text-green-400"><?php echo $_SESSION['vida_jugador']; ?> ❤️</span></p>
                        <p><span class="font-bold">Rondas:</span> <?php echo $_SESSION['ronda_actual']; ?></p>
                        <p><span class="font-bold">Héroes Restantes:</span> <?php echo count($_SESSION['heroes_disponibles_jugador'] ?? []); ?></p>
                    </div>
                </div>
                
                <div class="text-left">
                    <h3 class="text-xl font-bold text-red-400 mb-4">Equipo IA</h3>
                    <div class="space-y-2">
                        <p><span class="font-bold">Oponente:</span> Máquina de Guerra</p>
                        <p><span class="font-bold">Vida Final:</span> <span class="text-red-400"><?php echo $_SESSION['vida_ia']; ?> ❤️</span></p>
                        <p><span class="font-bold">Rondas:</span> <?php echo $_SESSION['ronda_actual']; ?></p>
                        <p><span class="font-bold">Héroes Restantes:</span> <?php echo count($_SESSION['heroes_disponibles_ia'] ?? []); ?></p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Log de batalla -->
        <div class="max-w-4xl mx-auto bg-gray-800 rounded-xl p-6 mb-8">
            <h3 class="text-2xl font-bold text-yellow-300 mb-4">📜 Resumen de la Batalla</h3>
            <div class="h-64 overflow-y-auto bg-gray-900 rounded-lg p-4 text-left">
                <?php if (!empty($_SESSION['log_batalla'])): ?>
                    <?php foreach ($_SESSION['log_batalla'] as $log): ?>
                        <div class="mb-2 p-2 bg-gray-700 rounded">
                            <span class="text-sm text-gray-400">[Ronda <?php echo $log['ronda']; ?>]</span>
                            <span class="ml-2"><?php echo $log['mensaje']; ?></span>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>

        <!-- Acciones -->
        <div class="space-y-4 max-w-md mx-auto">
            <a href="batalla.php" 
               class="block w-full py-4 bg-gradient-to-r from-blue-600 to-blue-800 text-white font-bold text-xl rounded-lg hover:from-blue-700 hover:to-blue-900 transition-all duration-300">
               🔄 Nueva Batalla
            </a>
            
            <a href="equipo.php" 
               class="block w-full py-4 bg-gradient-to-r from-green-600 to-green-800 text-white font-bold text-xl rounded-lg hover:from-green-700 hover:to-green-900 transition-all duration-300">
               ✏️ Modificar Equipo
            </a>
            
            <a href="index.php" 
               class="block w-full py-4 bg-gradient-to-r from-red-600 to-red-800 text-white font-bold text-xl rounded-lg hover:from-red-700 hover:to-red-900 transition-all duration-300">
               🏠 Volver al Inicio
            </a>
        </div>

        <!-- Frase final -->
        <div class="mt-12 p-6 bg-gradient-to-r from-purple-900 to-blue-900 rounded-xl">
            <p class="text-xl italic">
                <?php if ($victoria): ?>
                    "La victoria pertenece al más perseverante." - Sun Tzu
                <?php else: ?>
                    "La derrota es una lección, no un final." - Anónimo
                <?php endif; ?>
            </p>
        </div>
    </div>
</body>
</html>