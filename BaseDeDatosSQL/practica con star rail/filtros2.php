
<?php

define('BD_HOST', 'localhost');  
define('BD_NAME', 'honkai_star_rail');  
define('BD_USER', 'honkai');      
define('BD_PASS', '1234');       



// TODO: Crear conexión con mysqli

$conexion = new mysqli(BD_HOST, BD_USER, BD_PASS, BD_NAME); 

// TODO: Verificar si hay error

if ($conexion->connect_error) {
       die("❌ Error de conexión: " . $conexion->connect_error);
}

$sql = "SELECT * FROM personajes ORDER BY nombre ASC";

$resultado = $conexion->execute_query($sql);
$total = 0;
$totalRareza = 0;

if ($resultado && $resultado->num_rows > 0) {
    $personajes = $resultado->fetch_all(MYSQLI_ASSOC);
    $total = count($personajes);
    
} else {
    $personajes = [];
}




if ($_SERVER['REQUEST_METHOD'] === 'GET') {

    $elemento = $_GET['elemento'] ?? '';

        $stmt = $conexion->prepare("SELECT * FROM personajes WHERE elemento = ? ORDER BY nombre ASC");
        $stmt->bind_param("s", $elemento);
        $stmt->execute();
        $resultado = $stmt->get_result();
        
        if ($resultado && $resultado->num_rows > 0) {
            $personajes = $resultado->fetch_all(MYSQLI_ASSOC);
            $total = count($personajes);
        }
        
        $stmt->close();
    }



$conexion->close();


?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Filtrar por Elemento - Honkai Star Rail</title>
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
            padding: 30px;
        }
        
        .container {
            max-width: 1200px;
            margin: 0 auto;
            background: rgba(255, 255, 255, 0.05);
            padding: 30px;
            border-radius: 15px;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(102, 126, 234, 0.3);
        }
        
        h1 {
            text-align: center;
            margin-bottom: 20px;
            color: #667eea;
            font-size: 2.5rem;
        }
        
        .subtitle {
            text-align: center;
            color: #aaa;
            margin-bottom: 40px;
            font-size: 1.1rem;
        }
        
        .filter-section {
            background: rgba(102, 126, 234, 0.1);
            padding: 25px;
            border-radius: 12px;
            margin-bottom: 40px;
            border: 1px solid rgba(102, 126, 234, 0.2);
        }
        
        .filter-form {
            display: flex;
            gap: 15px;
            align-items: flex-end;
            flex-wrap: wrap;
        }
        
        .form-group {
            flex: 1;
            min-width: 300px;
        }
        
        .form-group label {
            display: block;
            margin-bottom: 10px;
            color: #c7d2fe;
            font-weight: 500;
            font-size: 1.1rem;
        }
        
        select {
            width: 100%;
            padding: 14px;
            background: rgba(30, 41, 59, 0.7);
            border: 1px solid rgba(102, 126, 234, 0.5);
            border-radius: 8px;
            color: white;
            font-size: 1rem;
            cursor: pointer;
        }
        
        select:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.2);
        }
        
        option {
            background: #1a1a2e;
            color: white;
            padding: 10px;
        }
        
        .filter-btn {
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            border: none;
            padding: 14px 30px;
            border-radius: 8px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: transform 0.2s;
            white-space: nowrap;
        }
        
        .filter-btn:hover {
            transform: translateY(-2px);
        }
        
        .clear-btn {
            background: rgba(255, 255, 255, 0.1);
            color: #ccc;
            border: 1px solid rgba(255, 255, 255, 0.2);
            padding: 14px 25px;
            border-radius: 8px;
            font-size: 1rem;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
            transition: all 0.3s;
        }
        
        .clear-btn:hover {
            background: rgba(255, 255, 255, 0.15);
            color: white;
        }
        
        .stats {
            background: rgba(255, 255, 255, 0.05);
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 30px;
            text-align: center;
            font-size: 1.1rem;
            border: 1px solid rgba(255, 255, 255, 0.1);
        }
        
        .highlight {
            color: #667eea;
            font-weight: bold;
            font-size: 1.2rem;
        }
        
        .elemento-badge {
            display: inline-block;
            padding: 8px 16px;
            border-radius: 20px;
            font-weight: 600;
            margin: 5px;
            text-align: center;
            min-width: 100px;
        }
        
        .elemento-fisico { background: linear-gradient(135deg, #9ca3af, #6b7280); }
        .elemento-fuego { background: linear-gradient(135deg, #f97316, #dc2626); }
        .elemento-hielo { background: linear-gradient(135deg, #0ea5e9, #0369a1); }
        .elemento-rayos { background: linear-gradient(135deg, #fbbf24, #d97706); }
        .elemento-viento { background: linear-gradient(135deg, #10b981, #059669); }
        .elemento-cuantum { background: linear-gradient(135deg, #8b5cf6, #7c3aed); }
        .elemento-imaginario { background: linear-gradient(135deg, #ec4899, #be185d); }
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        
        th {
            background: rgba(102, 126, 234, 0.3);
            padding: 15px;
            text-align: left;
            font-weight: 600;
            border-bottom: 2px solid #667eea;
        }
        
        td {
            padding: 12px 15px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }
        
        tr:hover {
            background: rgba(102, 126, 234, 0.1);
        }
        
        .rareza-5 {
            color: gold;
            font-weight: bold;
        }
        
        .rareza-4 {
            color: #9c27b0;
            font-weight: bold;
        }
        
        .imagen-personaje {
            width: 50px;
            height: 50px;
            object-fit: cover;
            border-radius: 8px;
            border: 2px solid #667eea;
        }
        
        .no-resultados {
            text-align: center;
            padding: 60px;
            color: #aaa;
            font-size: 1.2rem;
            background: rgba(255, 255, 255, 0.05);
            border-radius: 10px;
            margin-top: 20px;
        }
        
        .active-filter {
            background: rgba(102, 126, 234, 0.2);
            padding: 10px 20px;
            border-radius: 20px;
            display: inline-block;
            margin-top: 15px;
            border: 1px solid rgba(102, 126, 234, 0.4);
        }
        
        .elementos-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
            gap: 15px;
            margin-top: 25px;
        }
        
        .elemento-item {
            text-align: center;
            padding: 15px;
            border-radius: 10px;
            background: rgba(255, 255, 255, 0.05);
            transition: all 0.3s;
            cursor: pointer;
        }
        
        .elemento-item:hover {
            transform: translateY(-5px);
            background: rgba(255, 255, 255, 0.1);
        }
        
        .footer {
            text-align: center;
            margin-top: 50px;
            padding-top: 20px;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            color: #888;
        }
        
        @media (max-width: 768px) {
            .filter-form {
                flex-direction: column;
            }
            
            .form-group {
                min-width: 100%;
            }
            
            .filter-btn, .clear-btn {
                width: 100%;
                text-align: center;
            }
            
            .elementos-grid {
                grid-template-columns: repeat(auto-fill, minmax(120px, 1fr));
            }
            
            th, td {
                padding: 10px;
                font-size: 0.9rem;
            }
            
            .container {
                padding: 20px;
            }
        }
        
        @media (max-width: 480px) {
            body {
                padding: 15px;
            }
            
            h1 {
                font-size: 2rem;
            }
            
            table {
                font-size: 0.85rem;
            }
            
            .elementos-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>⚡ Filtrar por Elemento - Honkai Star Rail</h1>
        <p class="subtitle">Selecciona un elemento para filtrar los personajes</p>
        
        <div class="filter-section">
            <form method="GET" class="filter-form">
                <div class="form-group">
                    <label for="elemento">Elemento:</label>
                    <select name="elemento" id="elemento">
                        <option value="">Todos los elementos</option>
                        <option value="Físico" <?php echo ($filtro_elemento ?? '') === 'Físico' ? 'selected' : ''; ?>>
                            ⚪ Físico
                        </option>
                        <option value="Fuego" <?php echo ($filtro_elemento ?? '') === 'Fuego' ? 'selected' : ''; ?>>
                            🔥 Fuego
                        </option>
                        <option value="Hielo" <?php echo ($filtro_elemento ?? '') === 'Hielo' ? 'selected' : ''; ?>>
                            ❄️ Hielo
                        </option>
                        <option value="Rayos" <?php echo ($filtro_elemento ?? '') === 'Rayos' ? 'selected' : ''; ?>>
                            ⚡ Rayos
                        </option>
                        <option value="Viento" <?php echo ($filtro_elemento ?? '') === 'Viento' ? 'selected' : ''; ?>>
                            🌪️ Viento
                        </option>
                        <option value="Cuantúm" <?php echo ($filtro_elemento ?? '') === 'Cuantúm' ? 'selected' : ''; ?>>
                            💫 Cuantúm
                        </option>
                        <option value="Imaginario" <?php echo ($filtro_elemento ?? '') === 'Imaginario' ? 'selected' : ''; ?>>
                            🌀 Imaginario
                        </option>
                    </select>
                </div>
                
                <button type="submit" class="filter-btn">
                    🔍 Aplicar Filtro
                </button>
                
                <a href="filtros2.php" class="clear-btn">
                    ↻ Limpiar Filtro
                </a>
            </form>
            
            <!-- Mostrar filtro activo -->
            <?php if (!empty($filtro_elemento)): ?>
                <div class="active-filter">
                    Filtro activo: 
                    <span class="elemento-badge elemento-<?php echo strtolower($filtro_elemento); ?>">
                        <?php echo htmlspecialchars($filtro_elemento); ?>
                    </span>
                </div>
            <?php endif; ?>
            
            <!-- Grid de elementos (opcional) -->
            <div class="elementos-grid">
                <a href="?elemento=Físico" class="elemento-item elemento-fisico">⚪ Físico</a>
                <a href="?elemento=Fuego" class="elemento-item elemento-fuego">🔥 Fuego</a>
                <a href="?elemento=Hielo" class="elemento-item elemento-hielo">❄️ Hielo</a>
                <a href="?elemento=Rayos" class="elemento-item elemento-rayos">⚡ Rayos</a>
                <a href="?elemento=Viento" class="elemento-item elemento-viento">🌪️ Viento</a>
                <a href="?elemento=Cuantúm" class="elemento-item elemento-cuantum">💫 Cuantúm</a>
                <a href="?elemento=Imaginario" class="elemento-item elemento-imaginario">🌀 Imaginario</a>
            </div>
        </div>
        
        <div class="stats">
            <?php if (isset($total) && $total > 0): ?>
                Mostrando <span class="highlight"><?php echo $total; ?></span> personajes
                <?php if (!empty($filtro_elemento)): ?>
                    con elemento <span class="elemento-badge elemento-<?php echo strtolower($filtro_elemento); ?>">
                        <?php echo htmlspecialchars($filtro_elemento); ?>
                    </span>
                <?php endif; ?>
            <?php elseif (isset($total) && $total === 0): ?>
                No se encontraron personajes con el elemento seleccionado
            <?php else: ?>
                Selecciona un elemento para ver los personajes
            <?php endif; ?>
        </div>
        
        <?php if (!empty($personajes)): ?>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Imagen</th>
                        <th>Nombre</th>
                        <th>Elemento</th>
                        <th>Rareza</th>
                        <th>Ruta</th>
                        <th>Fecha Lanzamiento</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($personajes as $personaje): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($personaje['id_personaje']); ?></td>
                        <td>
                            <?php if (!empty($personaje['imagen_url'])): ?>
                                <img src="<?php echo htmlspecialchars($personaje['imagen_url']); ?>" 
                                     alt="<?php echo htmlspecialchars($personaje['nombre']); ?>"
                                     class="imagen-personaje">
                            <?php else: ?>
                                <span>Sin imagen</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <strong><?php echo htmlspecialchars($personaje['nombre']); ?></strong>
                            <?php if (!empty($personaje['alias'])): ?>
                                <br><small><?php echo htmlspecialchars($personaje['alias']); ?></small>
                            <?php endif; ?>
                        </td>
                        <td>
                            <span class="elemento-badge elemento-<?php echo strtolower($personaje['elemento']); ?>">
                                <?php echo htmlspecialchars($personaje['elemento']); ?>
                            </span>
                        </td>
                        <td class="<?php echo $personaje['rareza'] === '5 estrellas' ? 'rareza-5' : 'rareza-4'; ?>">
                            <?php echo htmlspecialchars($personaje['rareza']); ?>
                        </td>
                        <td><?php echo htmlspecialchars($personaje['ruta']); ?></td>
                        <td><?php echo htmlspecialchars($personaje['fecha_lanzamiento'] ?? 'N/A'); ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php elseif (isset($personajes) && empty($personajes)): ?>
            <div class="no-resultados">
                <h3>🚫 No se encontraron personajes</h3>
                <p>No hay personajes que coincidan con el elemento seleccionado.</p>
                <p>Prueba con otro elemento o <a href="filtros2.php" style="color: #667eea;">muestra todos</a>.</p>
            </div>
        <?php endif; ?>
        
        <div class="footer">
            <p>Ejercicio SQL #4 - Filtros por elemento | Honkai Star Rail Database</p>
            <p>
                <a href="consulta1.php" style="color: #667eea; margin-right: 15px;">← Ver todos los personajes</a>
                <a href="filtros1.php" style="color: #667eea; margin-right: 15px;">⭐ Filtrar por rareza</a>
                <a href="index.php" style="color: #667eea;">Volver al inicio</a>
            </p>
        </div>
    </div>
</body>
</html>