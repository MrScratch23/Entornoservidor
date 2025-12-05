<?php

define('BD_HOST', 'localhost');  
define('BD_NAME', 'honkai_star_rail');  
define('BD_USER', 'honkai');      
define('BD_PASS', '1234');    

$conexion = new mysqli(BD_HOST, BD_USER, BD_PASS, BD_NAME); 

if ($conexion->connect_error) {
    die("❌ Error de conexión: " . $conexion->connect_error);
}


$personajes = [];
$personaje_seleccionado = null;
$amigos = [];
$enemigos = [];


$sql = "SELECT * FROM personajes ORDER BY nombre ASC";
$resultado = $conexion->execute_query($sql);

if ($resultado && $resultado->num_rows > 0) {
    $personajes = $resultado->fetch_all(MYSQLI_ASSOC);
}


if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['personaje_id']) && !empty($_GET['personaje_id'])) {
    $personaje_id = intval($_GET['personaje_id']);
    
   
    $stmt = $conexion->prepare("SELECT * FROM personajes WHERE id_personaje = ?");
    $stmt->bind_param("i", $personaje_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $personaje_seleccionado = $result->fetch_assoc();
        

        $sqlAmigos = "SELECT p.* 
                      FROM personajes p 
                      WHERE p.id_personaje IN (
                          SELECT id_personaje2 
                          FROM relacion_personajes 
                          WHERE id_personaje1 = ? AND relacion = 'amigo'
                          UNION
                          SELECT id_personaje1 
                          FROM relacion_personajes 
                          WHERE id_personaje2 = ? AND relacion = 'amigo'
                      ) 
                      ORDER BY p.nombre";
        
        $stmtAmigos = $conexion->prepare($sqlAmigos);
        $stmtAmigos->bind_param("ii", $personaje_id, $personaje_id);
        $stmtAmigos->execute();
        $resultAmigos = $stmtAmigos->get_result();
        $amigos = $resultAmigos->fetch_all(MYSQLI_ASSOC);
        $stmtAmigos->close();
        
  
        $sqlEnemigos = "SELECT p.* 
                        FROM personajes p 
                        WHERE p.id_personaje IN (
                            SELECT id_personaje2 
                            FROM relacion_personajes 
                            WHERE id_personaje1 = ? AND relacion = 'enemigo'
                            UNION
                            SELECT id_personaje1 
                            FROM relacion_personajes 
                            WHERE id_personaje2 = ? AND relacion = 'enemigo'
                        ) 
                        ORDER BY p.nombre";
        
        $stmtEnemigos = $conexion->prepare($sqlEnemigos);
        $stmtEnemigos->bind_param("ii", $personaje_id, $personaje_id);
        $stmtEnemigos->execute();
        $resultEnemigos = $stmtEnemigos->get_result();
        $enemigos = $resultEnemigos->fetch_all(MYSQLI_ASSOC);
        $stmtEnemigos->close();
    }
    $stmt->close();
}

// 
// $conexion->close();
?>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>🎭 Relaciones entre Personajes - Honkai Star Rail</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        body {
            background: linear-gradient(135deg, #1a1a2e, #16213e, #0f3460);
            color: #fff;
            min-height: 100vh;
            padding: 30px;
        }
        
        .container {
            max-width: 1400px;
            margin: 0 auto;
            background: rgba(255, 255, 255, 0.05);
            padding: 40px;
            border-radius: 20px;
            border: 1px solid rgba(102, 126, 234, 0.3);
        }
        
        h1 {
            text-align: center;
            margin-bottom: 10px;
            background: linear-gradient(135deg, #667eea, #764ba2);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
            font-size: 3rem;
            font-weight: 800;
        }
        
        .subtitle {
            text-align: center;
            color: #a0aec0;
            margin-bottom: 40px;
            font-size: 1.2rem;
        }
        
        /* SELECTOR DE PERSONAJE */
        .selector-section {
            background: rgba(102, 126, 234, 0.1);
            padding: 30px;
            border-radius: 15px;
            margin-bottom: 40px;
            border: 1px solid rgba(102, 126, 234, 0.2);
        }
        
        .selector-form {
            display: flex;
            gap: 20px;
            align-items: flex-end;
            flex-wrap: wrap;
        }
        
        .form-group {
            flex: 1;
            min-width: 300px;
        }
        
        .form-group label {
            display: block;
            margin-bottom: 12px;
            color: #c7d2fe;
            font-weight: 600;
            font-size: 1.1rem;
        }
        
        select {
            width: 100%;
            padding: 16px;
            background: rgba(15, 23, 42, 0.8);
            border: 2px solid rgba(102, 126, 234, 0.5);
            border-radius: 10px;
            color: white;
            font-size: 1.1rem;
            cursor: pointer;
        }
        
        select:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.2);
        }
        
        .select-btn {
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            border: none;
            padding: 16px 40px;
            border-radius: 10px;
            font-size: 1.1rem;
            font-weight: 700;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 10px;
            white-space: nowrap;
        }
        
        .select-btn:hover {
            background: linear-gradient(135deg, #764ba2, #667eea);
        }
        
        /* INFO PERSONAJE */
        .personaje-info {
            background: rgba(255, 255, 255, 0.08);
            border-radius: 15px;
            padding: 30px;
            margin-bottom: 40px;
            display: flex;
            align-items: center;
            gap: 30px;
            border-left: 5px solid #667eea;
        }
        
        .personaje-imagen {
            width: 180px;
            height: 180px;
            object-fit: cover;
            border-radius: 15px;
            border: 3px solid #667eea;
        }
        
        .personaje-datos h3 {
            font-size: 2.2rem;
            margin-bottom: 10px;
            color: #e2e8f0;
        }
        
        .personaje-alias {
            color: #94a3b8;
            font-size: 1.3rem;
            margin-bottom: 20px;
            font-style: italic;
        }
        
        .datos-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 15px;
            margin-top: 20px;
        }
        
        .dato-item {
            background: rgba(255, 255, 255, 0.05);
            padding: 15px;
            border-radius: 10px;
        }
        
        .dato-label {
            color: #94a3b8;
            font-size: 0.9rem;
            margin-bottom: 5px;
        }
        
        .dato-valor {
            font-size: 1.2rem;
            font-weight: 600;
            color: #e2e8f0;
        }
        
        /* RELACIONES */
        .relaciones-section {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(400px, 1fr));
            gap: 30px;
            margin-bottom: 50px;
        }
        
        .relacion-card {
            background: rgba(255, 255, 255, 0.05);
            border-radius: 15px;
            padding: 30px;
            border-top: 5px solid;
            height: 100%;
        }
        
        .amigos-card {
            border-color: #10b981;
        }
        
        .enemigos-card {
            border-color: #ef4444;
        }
        
        .relacion-titulo {
            display: flex;
            align-items: center;
            gap: 15px;
            margin-bottom: 25px;
            font-size: 1.8rem;
        }
        
        .amigos-titulo {
            color: #10b981;
        }
        
        .enemigos-titulo {
            color: #ef4444;
        }
        
        .relacion-icono {
            font-size: 2rem;
        }
        
        /* LISTA DE RELACIONES */
        .lista-relaciones {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }
        
        .relacion-item {
            background: rgba(255, 255, 255, 0.08);
            padding: 20px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            gap: 20px;
            border: 1px solid rgba(255, 255, 255, 0.1);
        }
        
        .relacion-item:hover {
            background: rgba(255, 255, 255, 0.12);
        }
        
        .relacion-imagen {
            width: 70px;
            height: 70px;
            object-fit: cover;
            border-radius: 10px;
            border: 2px solid;
        }
        
        .amigo-imagen {
            border-color: #10b981;
        }
        
        .enemigo-imagen {
            border-color: #ef4444;
        }
        
        .relacion-info h4 {
            font-size: 1.3rem;
            margin-bottom: 5px;
            color: #e2e8f0;
        }
        
        .relacion-detalles {
            color: #94a3b8;
            font-size: 0.95rem;
        }
        
        /* BADGES */
        .badge {
            display: inline-block;
            padding: 6px 15px;
            border-radius: 20px;
            font-size: 0.9rem;
            font-weight: 600;
            margin-right: 8px;
            margin-bottom: 8px;
        }
        
        .badge-ruta {
            background: rgba(102, 126, 234, 0.2);
            color: #c7d2fe;
            border: 1px solid rgba(102, 126, 234, 0.4);
        }
        
        .badge-elemento {
            background: rgba(255, 255, 255, 0.1);
            color: #e2e8f0;
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        
        .badge-rareza {
            background: rgba(245, 158, 11, 0.2);
            color: #fcd34d;
            border: 1px solid rgba(245, 158, 11, 0.4);
        }
        
        /* SIN RELACIONES */
        .sin-relaciones {
            text-align: center;
            padding: 50px;
            color: #94a3b8;
            font-size: 1.1rem;
        }
        
        .sin-relaciones .icono {
            font-size: 3rem;
            margin-bottom: 20px;
            opacity: 0.5;
        }
        
        /* CONTADORES */
        .contadores {
            display: flex;
            justify-content: center;
            gap: 30px;
            margin: 30px 0;
        }
        
        .contador {
            text-align: center;
            padding: 25px;
            background: rgba(255, 255, 255, 0.05);
            border-radius: 15px;
            min-width: 150px;
            border-top: 4px solid;
        }
        
        .contador-amigos {
            border-color: #10b981;
        }
        
        .contador-enemigos {
            border-color: #ef4444;
        }
        
        .contador-numero {
            font-size: 3rem;
            font-weight: 800;
            margin-bottom: 10px;
        }
        
        .contador-amigos .contador-numero {
            color: #10b981;
        }
        
        .contador-enemigos .contador-numero {
            color: #ef4444;
        }
        
        .contador-label {
            color: #94a3b8;
            font-size: 1.1rem;
        }
        
        /* NAVEGACIÓN */
        .navegacion {
            text-align: center;
            margin-top: 50px;
            padding-top: 30px;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
        }
        
        .nav-links {
            display: flex;
            justify-content: center;
            gap: 20px;
            flex-wrap: wrap;
        }
        
        .nav-link {
            background: rgba(255, 255, 255, 0.05);
            color: #c7d2fe;
            padding: 12px 25px;
            border-radius: 8px;
            text-decoration: none;
            border: 1px solid rgba(102, 126, 234, 0.3);
        }
        
        .nav-link:hover {
            background: rgba(102, 126, 234, 0.2);
            color: white;
        }
        
        /* RESPONSIVE */
        @media (max-width: 1024px) {
            .container {
                padding: 25px;
            }
            
            .relaciones-section {
                grid-template-columns: 1fr;
            }
            
            .personaje-info {
                flex-direction: column;
                text-align: center;
            }
        }
        
        @media (max-width: 768px) {
            body {
                padding: 15px;
            }
            
            h1 {
                font-size: 2.2rem;
            }
            
            .selector-form {
                flex-direction: column;
            }
            
            .form-group {
                min-width: 100%;
            }
            
            .select-btn {
                width: 100%;
                justify-content: center;
            }
            
            .contadores {
                flex-direction: column;
                align-items: center;
            }
            
            .nav-links {
                flex-direction: column;
            }
        }
        
        @media (max-width: 480px) {
            h1 {
                font-size: 1.8rem;
            }
            
            .personaje-imagen {
                width: 140px;
                height: 140px;
            }
            
            .personaje-datos h3 {
                font-size: 1.8rem;
            }
            
            .relacion-card {
                padding: 20px;
            }
            
            .relacion-item {
                flex-direction: column;
                text-align: center;
                padding: 15px;
            }
            
            .datos-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- TÍTULO -->
        <h1>🎭 Relaciones entre Personajes</h1>
        <p class="subtitle">Explora las conexiones de amistad y rivalidad en Honkai: Star Rail</p>
        
        <!-- SELECTOR DE PERSONAJE -->
        <div class="selector-section">
            <form method="GET" class="selector-form">
                <div class="form-group">
                    <label for="personaje_id">Selecciona un personaje:</label>
                    <select name="personaje_id" id="personaje_id" required>
                        <option value="">-- Elige un personaje --</option>
                        <?php foreach($personajes as $p): ?>
                            <option value="<?php echo $p['id_personaje']; ?>"
                                <?php if(isset($personaje_seleccionado) && $personaje_seleccionado['id_personaje'] == $p['id_personaje']) echo 'selected'; ?>>
                                <?php echo htmlspecialchars($p['nombre']); ?> 
                                (<?php echo htmlspecialchars($p['ruta']); ?>)
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                
                <button type="submit" class="select-btn">
                    🔍 Ver Relaciones
                </button>
            </form>
        </div>
        
        <?php if (isset($personaje_seleccionado)): ?>
        
        <!-- INFORMACIÓN DEL PERSONAJE -->
        <div class="personaje-info">
            <img src="<?php echo htmlspecialchars($personaje_seleccionado['imagen_url']); ?>" 
                 alt="<?php echo htmlspecialchars($personaje_seleccionado['nombre']); ?>"
                 class="personaje-imagen">
            
            <div class="personaje-datos">
                <h3><?php echo htmlspecialchars($personaje_seleccionado['nombre']); ?></h3>
                <?php if (!empty($personaje_seleccionado['alias'])): ?>
                    <p class="personaje-alias">"<?php echo htmlspecialchars($personaje_seleccionado['alias']); ?>"</p>
                <?php endif; ?>
                
                <div class="datos-grid">
                    <div class="dato-item">
                        <div class="dato-label">Ruta</div>
                        <div class="dato-valor"><?php echo htmlspecialchars($personaje_seleccionado['ruta']); ?></div>
                    </div>
                    <div class="dato-item">
                        <div class="dato-label">Elemento</div>
                        <div class="dato-valor"><?php echo htmlspecialchars($personaje_seleccionado['elemento']); ?></div>
                    </div>
                    <div class="dato-item">
                        <div class="dato-label">Rareza</div>
                        <div class="dato-valor"><?php echo htmlspecialchars($personaje_seleccionado['rareza']); ?></div>
                    </div>
                    <div class="dato-item">
                        <div class="dato-label">Fecha Lanzamiento</div>
                        <div class="dato-valor"><?php echo htmlspecialchars($personaje_seleccionado['fecha_lanzamiento'] ?? 'N/A'); ?></div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- CONTADORES -->
        <div class="contadores">
            <div class="contador contador-amigos">
                <div class="contador-numero"><?php echo count($amigos); ?></div>
                <div class="contador-label">Amigos</div>
            </div>
            <div class="contador contador-enemigos">
                <div class="contador-numero"><?php echo count($enemigos); ?></div>
                <div class="contador-label">Enemigos</div>
            </div>
        </div>
        
        <!-- SECCIÓN DE RELACIONES -->
        <div class="relaciones-section">
            <!-- AMIGOS -->
            <div class="relacion-card amigos-card">
                <div class="relacion-titulo amigos-titulo">
                    <span class="relacion-icono">🤝</span>
                    <h2>Amigos y Aliados</h2>
                </div>
                
                <div class="lista-relaciones">
                    <?php if (!empty($amigos)): ?>
                        <?php foreach($amigos as $amigo): ?>
                        <div class="relacion-item">
                            <img src="<?php echo htmlspecialchars($amigo['imagen_url']); ?>" 
                                 alt="<?php echo htmlspecialchars($amigo['nombre']); ?>"
                                 class="relacion-imagen amigo-imagen">
                            
                            <div class="relacion-info">
                                <h4><?php echo htmlspecialchars($amigo['nombre']); ?></h4>
                                <div class="relacion-detalles">
                                    <span class="badge badge-ruta"><?php echo htmlspecialchars($amigo['ruta']); ?></span>
                                    <span class="badge badge-elemento"><?php echo htmlspecialchars($amigo['elemento']); ?></span>
                                    <span class="badge badge-rareza"><?php echo htmlspecialchars($amigo['rareza']); ?></span>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="sin-relaciones">
                            <div class="icono">😔</div>
                            <p>Este personaje no tiene amigos registrados.</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
            
            <!-- ENEMIGOS -->
            <div class="relacion-card enemigos-card">
                <div class="relacion-titulo enemigos-titulo">
                    <span class="relacion-icono">⚔️</span>
                    <h2>Enemigos y Rivales</h2>
                </div>
                
                <div class="lista-relaciones">
                    <?php if (!empty($enemigos)): ?>
                        <?php foreach($enemigos as $enemigo): ?>
                        <div class="relacion-item">
                            <img src="<?php echo htmlspecialchars($enemigo['imagen_url']); ?>" 
                                 alt="<?php echo htmlspecialchars($enemigo['nombre']); ?>"
                                 class="relacion-imagen enemigo-imagen">
                            
                            <div class="relacion-info">
                                <h4><?php echo htmlspecialchars($enemigo['nombre']); ?></h4>
                                <div class="relacion-detalles">
                                    <span class="badge badge-ruta"><?php echo htmlspecialchars($enemigo['ruta']); ?></span>
                                    <span class="badge badge-elemento"><?php echo htmlspecialchars($enemigo['elemento']); ?></span>
                                    <span class="badge badge-rareza"><?php echo htmlspecialchars($enemigo['rareza']); ?></span>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="sin-relaciones">
                            <div class="icono">🎉</div>
                            <p>¡Este personaje no tiene enemigos!</p>
                            <p>¡Todos lo quieren! (o aún no hay rivalidades registradas)</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        
        <?php else: ?>
        
        <!-- ESTADO INICIAL -->
        <div class="sin-relaciones" style="margin: 50px 0;">
            <div class="icono">🔍</div>
            <h3 style="margin-bottom: 20px; color: #c7d2fe;">Selecciona un personaje para ver sus relaciones</h3>
            <p>Elige un personaje del menú desplegable para descubrir sus amigos y enemigos en el universo de Honkai: Star Rail.</p>
        </div>
        
        <?php endif; ?>
        
        <!-- NAVEGACIÓN -->
        <div class="navegacion">
            <div class="nav-links">
                <a href="filtros3.php" class="nav-link">🛤️ Filtrar por Ruta</a>
                <a href="consulta1.php" class="nav-link">📋 Ver Todos los Personajes</a>
                <a href="index.php" class="nav-link">🏠 Inicio</a>
            </div>
            <p style="margin-top: 25px; color: #94a3b8; font-size: 0.9rem;">
                Ejercicio SQL #6 - Sistema de Relaciones entre Personajes
            </p>
        </div>
    </div>
</body>
</html>