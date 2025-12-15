<?php
session_start();
require_once 'includes/config.php';
require_once APP_ROOT . "/models/PersonajeModel.php";
require_once APP_ROOT . "/models/LoginModel.php";

// Inicializar modelos
$personajeModel = new PersonajeModel();
$loginModel = new LoginModel();

// Verificar login
if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php", true, 302);
    exit();
}

// Obtener datos
$personajes = $personajeModel->obtenerTodos();

// Obtener información del usuario actual
$usuario_actual = $loginModel->obtenerUsuarioPorId($_SESSION['usuario_id']);

// Convertir a array para JSON
$personajes_array = [];
foreach ($personajes as $p) {
    $personajes_array[] = [
        'id' => $p['id_personaje'],
        'nombre' => $p['nombre'],
        'rareza' => $p['rareza'],
        'ruta' => $p['ruta'],
        'elemento' => $p['elemento'],
        'imagen_url' => $p['imagen_url'],
        'descripcion' => $p['descripcion']
    ];
}

// estadisticas generales
$total = count($personajes);
$cinco_estrellas = count(array_filter($personajes, fn($p) => $p['rareza'] === '5 estrellas'));
$cuatro_estrellas = $total - $cinco_estrellas;
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Personajes - Honkai Star Rail</title>
    <!-- Font Awesome para íconos -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- CSS del diseño principal -->
    <link rel="stylesheet" href="paginaprincipal.css">
    <!-- CSS específico para personajes -->
    <link rel="stylesheet" href="personajes.css">
    <!-- CSS para detalles de personajes -->
    <link rel="stylesheet" href="detalles-personaje.css">
</head>
<body class="personajes-page">
    <!-- Header -->
    <header class="header-container">
        <div class="left-text">Hacia las estrellas</div>

        <img
            src="astral-express-honkai-star-rail.gif"
            alt="Logo principal"
            class="center-image"
        />

        <div class="header-right">
            <div class="user-info">
                <span class="user-welcome">
                    <i class="fas fa-user-circle"></i>
                    <?php echo htmlspecialchars($usuario_actual['nombre'] ?? $_SESSION['usuario_nombre'] ?? 'Usuario'); ?>
                </span>
                <a href="logout.php" class="btn-logout">
                    <i class="fas fa-sign-out-alt"></i> Salir
                </a>
            </div>
        </div>
    </header>

    <main>
        <!-- Menú de navegación -->
        <nav class="menu-categorias">
            <ul>
                <li>
                    <a href="index.php"><i class="fas fa-home"></i> Principal</a>
                </li>
                <li>
                    <a href="personajes.php" class="active"><i class="fas fa-users"></i> Personajes</a>
                </li>
                <li>
                    <a href="tierlist.php"><i class="fas fa-chart-bar"></i> Tier list</a>
                </li>
                <li>
                    <a href="memoriacaos.php"><i class="fas fa-brain"></i> Memoria del Caos</a>
                </li>
                <li>
                    <a href="puraficcion.php"><i class="fab fa-twitter"></i> Pura Ficción</a>
                </li>
                <li>
                    <a href="aposhadow.php"><i class="fas fa-radiation-alt"></i> Apocalyptic Shadow</a>
                </li>
                <li>
                    <a href="conosluz.php"><i class="fas fa-cube"></i> Conos de Luz</a>
                </li>
                <li>
                    <a href="artefactos.php"><i class="fas fa-dice"></i> Artefactos</a>
                </li>

                <li class="separator"></li>

                <li>
                    <a href="#"><i class="fas fa-book"></i> Guías</a>
                </li>
                <li>
                    <a href="#"><i class="fas fa-tools"></i> Herramientas</a>
                </li>

                <li class="separator"></li>

                <li>
                    <a href="https://github.com/MrScratch23" id="github-link">
                        <i class="fas fa-blog"></i> Github del creador
                    </a>
                </li>

                <li>
                    <a href="#" class="play-mac">
                        <i class="fab fa-apple"></i> Juega en Mac
                    </a>
                </li>
            </ul>
        </nav>

        <!-- Contenido principal -->
        <div class="contenido-principal">
            <div class="container">
                <header class="page-header">
                    <h1>🌟 Honkai Star Rail - Personajes</h1>
                    <div class="stats">
                        <div class="stat-card">
                            <div class="stat-number"><?php echo $total; ?></div>
                            <div>Personajes totales</div>
                        </div>
                        <div class="stat-card">
                            <div class="stat-number"><?php echo $cinco_estrellas; ?></div>
                            <div>5 estrellas</div>
                        </div>
                        <div class="stat-card">
                            <div class="stat-number"><?php echo $cuatro_estrellas; ?></div>
                            <div>4 estrellas</div>
                        </div>
                    </div>
                </header>
                
                <!-- Filtros de personajes -->
                <div class="filters">
                    <div class="filter-group">
                        <label>🔍 Buscar por nombre</label>
                        <div class="search-box">
                            <input type="text" id="buscarInput" placeholder="Ej: Kafka, Seele...">
                            <button type="button" id="buscarBtn" class="filter-btn">Buscar</button>
                        </div>
                    </div>
                    
                    <div class="filter-group">
                        <label>⭐ Filtrar por rareza</label>
                        <select id="rarezaSelect">
                            <option value="">Todas las rarezas</option>
                            <option value="5 estrellas">5 estrellas ⭐⭐⭐⭐⭐</option>
                            <option value="4 estrellas">4 estrellas ⭐⭐⭐⭐</option>
                        </select>
                        <button type="button" id="rarezaBtn" class="filter-btn">Filtrar</button>
                    </div>
                    
                    <div class="filter-group">
                        <label>🛤️ Filtrar por ruta</label>
                        <select id="rutaSelect">
                            <option value="">Todas las rutas</option>
                            <option value="Destrucción">Destrucción</option>
                            <option value="Cacería">Cacería</option>
                            <option value="Erudición">Erudición</option>
                            <option value="Armonía">Armonía</option>
                            <option value="Nihilidad">Nihilidad</option>
                            <option value="Preservación">Preservación</option>
                            <option value="Abundancia">Abundancia</option>
                        </select>
                        <button type="button" id="rutaBtn" class="filter-btn">Filtrar</button>
                    </div>
                    
                    <div class="filter-group">
                        <label>⚡ Filtrar por elemento</label>
                        <select id="elementoSelect">
                            <option value="">Todos los elementos</option>
                            <option value="Físico">Físico</option>
                            <option value="Fuego">Fuego</option>
                            <option value="Hielo">Hielo</option>
                            <option value="Rayos">Rayos</option>
                            <option value="Viento">Viento</option>
                            <option value="Cuantúm">Cuantúm</option>
                            <option value="Imaginario">Imaginario</option>
                        </select>
                        <button type="button" id="elementoBtn" class="filter-btn">Filtrar</button>
                    </div>
                </div>
                
                <!-- Contador de resultados -->
                <div id="contadorResultados" class="stats" style="display: none; margin-top: 20px;">
                    <div class="stat-card">
                        <div class="stat-number" id="resultadosCount">0</div>
                        <div>Resultados encontrados</div>
                    </div>
                </div>
                
                <!-- Grid de personajes -->
                <div id="charactersGrid" class="characters-grid">
                    <?php if (empty($personajes)): ?>
                        <div class="no-results">
                            <h3>🚫 No se encontraron personajes</h3>
                            <p>Intenta con otros filtros o términos de búsqueda.</p>
                        </div>
                    <?php else: ?>
                        <?php foreach ($personajes as $personaje): ?>
                            <div class="character-card" 
                                 data-id="<?php echo htmlspecialchars($personaje['id_personaje']); ?>"
                                 data-rareza="<?php echo htmlspecialchars($personaje['rareza']); ?>" 
                                 data-ruta="<?php echo htmlspecialchars($personaje['ruta']); ?>" 
                                 data-elemento="<?php echo htmlspecialchars($personaje['elemento']); ?>"
                                 data-nombre="<?php echo htmlspecialchars(strtolower($personaje['nombre'])); ?>">
                                <img src="<?php echo htmlspecialchars($personaje['imagen_url']); ?>" 
                                     alt="<?php echo htmlspecialchars($personaje['nombre']); ?>"
                                     class="character-image">
                                <div class="character-info">
                                    <h3 class="character-name"><?php echo htmlspecialchars($personaje['nombre']); ?></h3>
                                    <div class="character-meta">
                                        <span class="rareza" data-rarity="<?php echo htmlspecialchars($personaje['rareza']); ?>">
                                            <?php echo htmlspecialchars($personaje['rareza']); ?>
                                        </span>
                                        <span class="ruta"><?php echo htmlspecialchars($personaje['ruta']); ?></span>
                                    </div>
                                    <div style="margin: 8px 0;">
                                        <span class="elemento"><?php echo htmlspecialchars($personaje['elemento']); ?></span>
                                    </div>
                                    <p class="character-desc">
                                        <?php echo htmlspecialchars($personaje['descripcion']); ?>
                                    </p>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
                
                <!-- Botón para resetear filtros -->
                <div class="reset-filters" id="resetContainer" style="display: none;">
                    <a href="#" id="resetBtn">↻ Quitar todos los filtros</a>
                </div>
            </div>
        </div>
    </main>

    <footer class="footer">
        <p>
            &copy; 2025 Rubén Daniel Ternero Molina. Este sitio es un proyecto
            personal sin fines comerciales. Honkai: Star Rail y todo su contenido
            son propiedad de miHoYo / HoYoverse.
        </p>
        <p>
            <i class="fas fa-users"></i> Conectado como: 
            <?php echo htmlspecialchars($usuario_actual['nombre'] ?? $_SESSION['usuario_nombre'] ?? 'Usuario'); ?> | 
            <i class="fas fa-star"></i> Total de personajes: <?php echo $total; ?>
        </p>
    </footer>

    <!-- TODOS LOS SCRIPTS AL FINAL DEL BODY -->
    <script>
        // Pasar los personajes desde PHP a JavaScript
        window.personajesData = <?php echo json_encode($personajes_array); ?>;
        // Pasar el ID del usuario actual para los comentarios
        window.currentUserId = <?php echo $_SESSION['usuario_id']; ?>;
    </script>
    
    <!-- JavaScript para los filtros -->
    <script src="personajes.js"></script>
    
    <!-- JavaScript para detalles de personajes -->
    <script src="detalles-personaje.js"></script>
</body>
</html>