<?php
session_start();
require_once 'includes/config.php';
require_once APP_ROOT . "/models/PersonajeModel.php";

$model = new PersonajeModel();

if (!isset($_SESSION['usuario'])) {
    header("Location: login.php", true, 302);
    exit();
}



// Filtros
$filtro_rareza = $_GET['rareza'] ?? '';
$filtro_ruta = $_GET['ruta'] ?? '';
$filtro_elemento = $_GET['elemento'] ?? '';
$busqueda = $_GET['buscar'] ?? '';

// si no hubiera ningun filtro indicado por la busuqeda, se muestran todos
if (!empty($busqueda)) {
    $personajes = $model->buscar($busqueda);
} elseif (!empty($filtro_rareza)) {
    $personajes = $model->obtenerPorRareza($filtro_rareza);
} elseif (!empty($filtro_ruta)) {
    $personajes = $model->obtenerPorRuta($filtro_ruta);
} elseif (!empty($filtro_elemento)) {
    $personajes = $model->obtenerPorElemento($filtro_elemento);
} else {
    $personajes = $model->obtenerTodos();
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
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        body {
            background: linear-gradient(135deg, #0f0c29, #302b63, #24243e);
            color: #fff;
            min-height: 100vh;
            padding: 20px;
        }
        
        .container {
            max-width: 1200px;
            margin: 0 auto;
        }
        
        header {
            text-align: center;
            margin-bottom: 40px;
            padding: 20px;
            background: rgba(0, 0, 0, 0.5);
            border-radius: 20px;
            border: 1px solid #667eea;
        }
        
        h1 {
            font-size: 2.8rem;
            margin-bottom: 10px;
            background: linear-gradient(90deg, #667eea, #764ba2);
            background-clip: text;
            color: transparent;
        }
        
        .stats {
            display: flex;
            justify-content: center;
            gap: 30px;
            margin: 20px 0;
            flex-wrap: wrap;
        }
        
        .stat-card {
            background: rgba(255, 255, 255, 0.1);
            padding: 15px 25px;
            border-radius: 10px;
            text-align: center;
            backdrop-filter: blur(10px);
            min-width: 120px;
        }
        
        .stat-number {
            font-size: 2rem;
            font-weight: bold;
            color: #667eea;
        }
        
        .filters {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
            margin-bottom: 30px;
            justify-content: center;
        }
        
        .filter-group {
            background: rgba(255, 255, 255, 0.1);
            padding: 15px;
            border-radius: 10px;
            min-width: 200px;
            flex: 1;
        }
        
        .filter-group label {
            display: block;
            margin-bottom: 8px;
            color: #aaa;
            font-size: 0.9rem;
        }
        
        select, input, .filter-btn {
            width: 100%;
            padding: 12px;
            border: none;
            border-radius: 8px;
            background: rgba(255, 255, 255, 0.15);
            color: white;
            font-size: 1rem;
        }
        
        option {
            background: #1a1a2e;
            color: white;
        }
        
        .filter-btn {
            background: linear-gradient(135deg, #667eea, #764ba2);
            cursor: pointer;
            font-weight: bold;
            transition: transform 0.2s;
            text-align: center;
            margin-top: 10px;
            text-decoration: none;
            display: block;
        }
        
        .filter-btn:hover {
            transform: translateY(-2px);
        }
        
        .search-box {
            display: flex;
            gap: 10px;
            margin-bottom: 30px;
        }
        
        .search-box input {
            flex: 1;
        }
        
        .search-box .filter-btn {
            margin-top: 0;
            width: auto;
            padding: 12px 25px;
        }
        
        .characters-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 25px;
            margin-top: 30px;
        }
        
        .character-card {
            background: rgba(255, 255, 255, 0.05);
            border-radius: 15px;
            overflow: hidden;
            transition: transform 0.3s, box-shadow 0.3s;
            border: 1px solid rgba(102, 126, 234, 0.3);
            display: flex;
            flex-direction: column;
        }
        
        .character-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 30px rgba(102, 126, 234, 0.4);
            border-color: #667eea;
        }
        
        .character-image {
            width: 100%;
            height: 250px;
            object-fit: cover;
            border-bottom: 2px solid #667eea;
        }
        
        .character-info {
            padding: 20px;
            flex: 1;
        }
        
        .character-name {
            font-size: 1.4rem;
            margin-bottom: 5px;
            color: #fff;
        }
        
        .character-meta {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
            align-items: center;
        }
        
        .rareza {
            font-weight: bold;
            color: gold;
            font-size: 0.9rem;
        }
        
        .rareza[data-rarity="4 estrellas"] {
            color: #9c27b0;
        }
        
        .ruta, .elemento {
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 0.85rem;
            background: rgba(255, 255, 255, 0.1);
        }
        
        .character-desc {
            font-size: 0.95rem;
            color: #ccc;
            line-height: 1.5;
            margin-top: 10px;
            max-height: 4.5em;
            overflow: hidden;
            position: relative;
        }
        
        .character-desc:after {
            content: '';
            position: absolute;
            bottom: 0;
            right: 0;
            width: 40%;
            height: 1.5em;
            background: linear-gradient(to right, transparent, rgba(15, 12, 41, 0.8));
        }
        
        .no-results {
            text-align: center;
            padding: 50px;
            grid-column: 1 / -1;
            color: #aaa;
            font-size: 1.2rem;
        }
        
        .reset-filters {
            text-align: center;
            margin-top: 30px;
        }
        
        .reset-filters a {
            color: #667eea;
            text-decoration: none;
            font-size: 1.1rem;
            padding: 10px 20px;
            border: 1px solid #667eea;
            border-radius: 8px;
            transition: all 0.3s;
        }
        
        .reset-filters a:hover {
            background: rgba(102, 126, 234, 0.2);
        }
        
        footer {
            text-align: center;
            margin-top: 50px;
            padding: 20px;
            color: #888;
            font-size: 0.9rem;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
        }
        
        @media (max-width: 768px) {
            .characters-grid {
                grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            }
            
            .filters {
                flex-direction: column;
            }
            
            .filter-group {
                min-width: auto;
            }
            
            h1 {
                font-size: 2.2rem;
            }
            
            .character-image {
                height: 220px;
            }
        }
        
        @media (max-width: 480px) {
            .characters-grid {
                grid-template-columns: 1fr;
            }
            
            .character-image {
                height: 200px;
            }
            
            .stats {
                gap: 15px;
            }
            
            .stat-card {
                padding: 12px 20px;
                min-width: 100px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <header>
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
        
        <div class="filters">
            <!-- BÚSQUEDA -->
            <div class="filter-group">
                <label>🔍 Buscar por nombre</label>
                <form method="GET" class="search-box">
                    <input type="text" name="buscar" placeholder="Ej: Kafka, Seele..." value="<?php echo htmlspecialchars($busqueda); ?>">
                    <button type="submit" class="filter-btn">Buscar</button>
                </form>
            </div>
            
            <!-- FILTRO RAREZA -->
            <div class="filter-group">
                <label>⭐ Filtrar por rareza</label>
                <form method="GET">
                    <select name="rareza">
                        <option value="">Todas las rarezas</option>
                        <option value="5 estrellas" <?php echo $filtro_rareza === '5 estrellas' ? 'selected' : ''; ?>>5 estrellas ⭐⭐⭐⭐⭐</option>
                        <option value="4 estrellas" <?php echo $filtro_rareza === '4 estrellas' ? 'selected' : ''; ?>>4 estrellas ⭐⭐⭐⭐</option>
                    </select>
                    <button type="submit" class="filter-btn">Filtrar</button>
                </form>
            </div>
            
            <!-- FILTRO RUTA -->
            <div class="filter-group">
                <label>🛤️ Filtrar por ruta</label>
                <form method="GET">
                    <select name="ruta">
                        <option value="">Todas las rutas</option>
                        <option value="Destrucción" <?php echo $filtro_ruta === 'Destrucción' ? 'selected' : ''; ?>>Destrucción</option>
                        <option value="Cacería" <?php echo $filtro_ruta === 'Cacería' ? 'selected' : ''; ?>>Cacería</option>
                        <option value="Erudición" <?php echo $filtro_ruta === 'Erudición' ? 'selected' : ''; ?>>Erudición</option>
                        <option value="Armonía" <?php echo $filtro_ruta === 'Armonía' ? 'selected' : ''; ?>>Armonía</option>
                        <option value="Nihilidad" <?php echo $filtro_ruta === 'Nihilidad' ? 'selected' : ''; ?>>Nihilidad</option>
                        <option value="Preservación" <?php echo $filtro_ruta === 'Preservación' ? 'selected' : ''; ?>>Preservación</option>
                        <option value="Abundancia" <?php echo $filtro_ruta === 'Abundancia' ? 'selected' : ''; ?>>Abundancia</option>
                    </select>
                    <button type="submit" class="filter-btn">Filtrar</button>
                </form>
            </div>
            
            <!-- FILTRO ELEMENTO -->
            <div class="filter-group">
                <label>⚡ Filtrar por elemento</label>
                <form method="GET">
                    <select name="elemento">
                        <option value="">Todos los elementos</option>
                        <option value="Físico" <?php echo $filtro_elemento === 'Físico' ? 'selected' : ''; ?>>Físico</option>
                        <option value="Fuego" <?php echo $filtro_elemento === 'Fuego' ? 'selected' : ''; ?>>Fuego</option>
                        <option value="Hielo" <?php echo $filtro_elemento === 'Hielo' ? 'selected' : ''; ?>>Hielo</option>
                        <option value="Rayos" <?php echo $filtro_elemento === 'Rayos' ? 'selected' : ''; ?>>Rayos</option>
                        <option value="Viento" <?php echo $filtro_elemento === 'Viento' ? 'selected' : ''; ?>>Viento</option>
                        <option value="Cuantúm" <?php echo $filtro_elemento === 'Cuantúm' ? 'selected' : ''; ?>>Cuantúm</option>
                        <option value="Imaginario" <?php echo $filtro_elemento === 'Imaginario' ? 'selected' : ''; ?>>Imaginario</option>
                    </select>
                    <button type="submit" class="filter-btn">Filtrar</button>
                </form>
            </div>
        </div>
        
        <div class="characters-grid">
            <?php if (empty($personajes)): ?>
                <div class="no-results">
                    <h3>🚫 No se encontraron personajes</h3>
                    <p>Intenta con otros filtros o términos de búsqueda.</p>
                </div>
            <?php else: ?>
                <?php foreach ($personajes as $personaje): ?>
                    <div class="character-card">
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
        
        <?php if ($filtro_rareza || $filtro_ruta || $filtro_elemento || $busqueda): ?>
            <div class="reset-filters">
                <a href="index.php">↻ Quitar todos los filtros</a>
            </div>
        <?php endif; ?>
        
        <footer>
            <p>Base de datos de personajes de Honkai: Star Rail | Total: <?php echo $total; ?> personajes</p>
        </footer>
    </div>
</body>
</html>