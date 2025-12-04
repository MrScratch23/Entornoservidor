<?php
/*
INSTRUCCIONES PARA TU CÓDIGO PHP:

1. CREAR CONEXIÓN:
   - Usar mysqli con localhost, root, sin contraseña, BD honkai_star_rail
   - Verificar si hay error con connect_error
   - Si hay error, usar die() para mostrar mensaje y terminar

   

2. PREPARAR Y EJECUTAR CONSULTA:
   - SQL: "SELECT * FROM personajes ORDER BY nombre ASC"
   - Ejecutar query() sobre la conexión
   - Guardar resultado en variable $resultado





3. OBTENER DATOS:
   - Si $resultado es válido Y num_rows > 0:
        * Usar fetch_all(MYSQLI_ASSOC) para obtener array completo
        * Guardar en $personajes
        * Contar con count() y guardar en $total
   - Si no hay resultados:
        * $personajes = array vacío []
        * $total = 0

4. CERRAR CONEXIÓN:
   - Usar close() sobre la conexión

VARIABLES QUE DEBES CREAR:
- $personajes: array con todos los personajes
- $total: número total de personajes
*/

// ESCRIBE TU CÓDIGO PHP AQUÍ ABAJO
// ↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓

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

if ($resultado && $resultado->num_rows > 0) {
    $personajes = $resultado->fetch_all(MYSQLI_ASSOC);
    $total = count($personajes);
    
} else {
    $personajes = [];
}

$conexion->close();

?>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listado de Personajes - Honkai Star Rail</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        body {
            background: linear-gradient(135deg, #0f0c29, #302b63);
            color: white;
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
            margin-bottom: 30px;
            color: #667eea;
            font-size: 2.5rem;
        }
        
        .stats {
            background: rgba(102, 126, 234, 0.1);
            padding: 15px;
            border-radius: 10px;
            margin-bottom: 30px;
            text-align: center;
            font-size: 1.1rem;
        }
        
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
        
        .elemento {
            display: inline-block;
            padding: 4px 10px;
            border-radius: 15px;
            font-size: 0.85rem;
            background: rgba(255, 255, 255, 0.1);
            margin-right: 5px;
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
            padding: 40px;
            color: #aaa;
            font-size: 1.2rem;
        }
        
        .footer {
            text-align: center;
            margin-top: 40px;
            padding-top: 20px;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            color: #888;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>🌟 Personajes de Honkai Star Rail</h1>
        
        <div class="stats">
            Total de personajes encontrados: <?php echo $total ?? 0; ?>
        </div>
        
        <?php if (!empty($personajes)): ?>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Imagen</th>
                        <th>Nombre</th>
                        <th>Rareza</th>
                        <th>Ruta</th>
                        <th>Elemento</th>
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
                        <td class="<?php echo $personaje['rareza'] === '5 estrellas' ? 'rareza-5' : 'rareza-4'; ?>">
                            <?php echo htmlspecialchars($personaje['rareza']); ?>
                        </td>
                        <td><?php echo htmlspecialchars($personaje['ruta']); ?></td>
                        <td>
                            <span class="elemento"><?php echo htmlspecialchars($personaje['elemento']); ?></span>
                        </td>
                        <td><?php echo htmlspecialchars($personaje['fecha_lanzamiento'] ?? 'N/A'); ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <div class="no-resultados">
                <h3>🚫 No se encontraron personajes</h3>
                <p>La base de datos está vacía o hubo un error.</p>
            </div>
        <?php endif; ?>
        
        <div class="footer">
            <p>Base de datos de Honkai: Star Rail | Ejercicio SQL #2</p>
        </div>
    </div>
</body>
</html>