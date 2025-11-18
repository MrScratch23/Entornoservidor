<?php
session_start();

// Inicializar carrito si no existe
if (!isset($_SESSION['carrito'])) {
    $_SESSION['carrito'] = [];
}

// Procesar agregar al carrito
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['agregar_carrito'])) {
    $producto_carrito = [
        'nombre' => $_POST['producto_nombre'],
        'precio' => floatval($_POST['producto_precio']),
        'categoria' => $_POST['producto_categoria']
    ];
    
    $_SESSION['carrito'][] = $producto_carrito;
    header('Location: ' . $_SERVER['PHP_SELF']);
    exit;
}

// Vaciar carrito
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['vaciar_carrito'])) {
    $_SESSION['carrito'] = [];
    header('Location: ' . $_SERVER['PHP_SELF']);
    exit;
}

// Guardar preferencias
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['guardar_preferencias'])) {
    $productos_pagina = $_POST['productos_pagina'] ?? 10;
    $orden = $_POST['orden'] ?? 'nombre';
    
    setcookie('productos_pagina', $productos_pagina, time() + (30 * 24 * 60 * 60), '/');
    setcookie('orden', $orden, time() + (30 * 24 * 60 * 60), '/');
    
    header('Location: ' . $_SERVER['PHP_SELF']);
    exit;
}

// Limpiar preferencias
if (isset($_GET['accion']) && $_GET['accion'] === 'limpiar') {
    setcookie('productos_pagina', '', time() - 3600, '/');
    setcookie('orden', '', time() - 3600, '/');
    header('Location: ' . $_SERVER['PHP_SELF']);
    exit;
}

function leerProductos($archivo) {
    if (!file_exists($archivo)) {
        return [];
    }
    
    $manejador = fopen($archivo, "r");
    if (!$manejador) {
        return [];
    }
    
    $productos = [];
    
    while (!feof($manejador)) {
        $linea = fgets($manejador);
        
        if ($linea === false) continue;
        
        $linea = trim($linea);
        
        if (empty($linea)) continue;
        
        $partes = explode('|', $linea);
        
        if (count($partes) === 5) {
            $productos[] = [
                'nombre' => $partes[0],
                'precio' => $partes[1],
                'categoria' => $partes[2],
                'stock' => $partes[3],
                'descripcion' => $partes[4]
            ];
        }
    }
    
    fclose($manejador);
    return $productos;
}

function agregarProductoTXT($archivo, $producto) {
    $linea = implode('|', [
        $producto['nombre'],
        $producto['precio'],
        $producto['categoria'],
        $producto['stock'],
        $producto['descripcion']
    ]);
    file_put_contents($archivo, $linea . PHP_EOL, FILE_APPEND);
    return true;
}

$sumaTotal = 0;
$archivo = "productos.txt";
$productos = leerProductos($archivo);
$mensajeTabla = "";
$carrito = $_SESSION['carrito'];
$errores = [];

foreach ($productos as $producto) {
    $mensajeTabla .= "<tr>";
    $mensajeTabla .= '<td>' . $producto['nombre'] . '</td>';
    $mensajeTabla .= '<td>' . $producto['precio'] . '</td>';
    $mensajeTabla .= '<td>' . $producto['categoria'] . '</td>';
    $mensajeTabla .= '<td>' . $producto['stock'] . '</td>';
    $mensajeTabla .= '<td>' . $producto['descripcion'] . '</td>';
    $mensajeTabla .= '<td>
        <form method="POST" style="display: inline;">
            <input type="hidden" name="producto_nombre" value="' . htmlspecialchars($producto['nombre']) . '">
            <input type="hidden" name="producto_precio" value="' . htmlspecialchars($producto['precio']) . '">
            <input type="hidden" name="producto_categoria" value="' . htmlspecialchars($producto['categoria']) . '">
            <button type="submit" name="agregar_carrito" style="background: #2196F3; padding: 5px 10px; font-size: 0.8em;">🛒 Agregar</button>
        </form>
    </td>';
    $mensajeTabla .= "</tr>";
    $sumaTotal += $producto['precio'];
}

$mensajeCarrito = "<ul>";
foreach ($carrito as $producto) {
    $mensajeCarrito .= '<li> ' . $producto['nombre'] . ' - $' . $producto['precio'] . '</li>';
}
$mensajeCarrito .= "</ul>";

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['agregar_producto'])) {
    $nombre = htmlspecialchars(trim($_POST['nombre'])) ?? '';
    $precio = htmlspecialchars(trim($_POST['precio'])) ?? '';
    $categoria = htmlspecialchars($_POST['categoria']) ?? '';
    $stock = htmlspecialchars(trim($_POST['stock'])) ?? '';
    $descripcion = htmlspecialchars(trim($_POST['descripcion'])) ?? 'Sin descripcion';

    if (empty($nombre)) {
        $errores['nombre'] = "El campo nombre no puede estar vacio";
    }

    if (empty($precio)) {
        $errores['precio'] = "El precio no puede estar vacío.";
    } elseif (!is_numeric($precio)) {
        $errores['precio'] = "El precio debe ser un número.";
    }

    $precio = floatval($precio);

    if (empty($categoria)) {
        $errores['categoria'] = "El campo categoria no puede estar vacio";
    }

    if (empty($stock)) {
        $errores['stock'] = "El stock no puede estar vacío.";
    } elseif (!is_numeric($stock)) {
        $errores['stock'] = "El stock debe ser un número.";
    }

    if (empty($errores)) {
        $productoNuevo = [
            'nombre' => $nombre,
            'precio' => $precio,
            'categoria' => $categoria,
            'stock' => $stock,
            'descripcion' => $descripcion
        ];
        agregarProductoTXT($archivo, $productoNuevo);
        header('Location: ' . $_SERVER['PHP_SELF']);
        exit;
    }
}

$totalCarrito = 0;
foreach ($carrito as $producto) {
    $totalCarrito += $producto['precio'];
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestor de Productos</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }
        .container {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 30px;
            margin-top: 20px;
        }
        .seccion {
            border: 2px solid #ddd;
            padding: 20px;
            border-radius: 10px;
            background: #f9f9f9;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 10px 0;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }
        th {
            background: #4CAF50;
            color: white;
        }
        tr:nth-child(even) {
            background: #f2f2f2;
        }
        .form-group {
            margin: 10px 0;
        }
        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }
        input[type="text"], input[type="number"], textarea {
            width: 100%;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        button {
            background: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            margin: 5px;
        }
        button:hover {
            background: #45a049;
        }
        .btn-eliminar {
            background: #f44336;
        }
        .btn-eliminar:hover {
            background: #d32f2f;
        }
        .carrito-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px;
            border-bottom: 1px solid #ddd;
        }
        .preferencias {
            background: #e3f2fd;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
        }
        .error {
            color: red;
            font-size: 0.9em;
            margin-top: 5px;
        }
    </style>
</head>
<body>
    <h1>🛍️ Gestor de Productos</h1>

    <!-- Preferencias del usuario -->
    <div class="preferencias">
        <h3>🎨 Preferencias</h3>
        <p><strong>Productos por página:</strong> <?php echo $_COOKIE['productos_pagina'] ?? 10; ?></p>
        <p><strong>Ordenar por:</strong> <?php echo $_COOKIE['orden'] ?? 'nombre'; ?></p>
        <a href="gestor_productos.php?accion=limpiar">🧹 Limpiar preferencias</a>
    </div>

    <div class="container">
        <!-- Columna izquierda: Gestión de productos -->
        <div class="seccion">
            <h2>📦 Gestión de Productos</h2>
            
            <!-- Formulario para agregar producto -->
            <form method="POST" action="gestor_productos.php">
                <h3>Agregar Nuevo Producto</h3>
                
                <div class="form-group">
                    <label for="nombre">Nombre del Producto:</label>
                    <input type="text" id="nombre" name="nombre">
                    <?php if (isset($errores['nombre'])): ?>
                        <br><span style="color: red;"><?php echo $errores['nombre']; ?></span>
                    <?php endif; ?>
                </div>
                
                <div class="form-group">
                    <label for="precio">Precio ($):</label>
                    <input type="number" id="precio" name="precio" step="0.01" min="0">
                    <?php if (isset($errores['precio'])): ?>
                        <br><span style="color: red;"><?php echo $errores['precio']; ?></span>
                    <?php endif; ?>
                </div>
                
                <div class="form-group">
                    <label for="categoria">Categoría:</label>
                    <input type="text" id="categoria" name="categoria">
                    <?php if (isset($errores['categoria'])): ?>
                        <br><span style="color: red;"><?php echo $errores['categoria']; ?></span>
                    <?php endif; ?>
                </div>
                
                <div class="form-group">
                    <label for="stock">Stock:</label>
                    <input type="number" id="stock" name="stock" min="0">
                    <?php if (isset($errores['stock'])): ?>
                        <br><span style="color: red;"><?php echo $errores['stock']; ?></span>
                    <?php endif; ?>
                </div>
                
                <div class="form-group">
                    <label for="descripcion">Descripción:</label>
                    <textarea id="descripcion" name="descripcion" rows="3"></textarea>
                </div>
                
                <button type="submit" name="agregar_producto">➕ Agregar Producto</button>
            </form>

            <hr>

            <!-- Lista de productos desde archivo -->
            <h3>📋 Productos Disponibles</h3>
            <table>
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Precio</th>
                        <th>Categoría</th>
                        <th>Stock</th>
                        <th>Descripción</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                   <?php
                    if (empty($productos)) {
                        echo '<tr><td colspan="6" style="text-align: center;">No hay productos cargados</td></tr>';
                    } else {
                        echo $mensajeTabla;
                    }
                   ?>
                </tbody>
            </table>
        </div>

        <!-- Columna derecha: Carrito de compras -->
        <div class="seccion">
            <h2>🛒 Carrito de Compras</h2>
            
            <!-- Carrito actual -->
            <div id="carrito">
                <?php if (empty($carrito)): ?>
                    <p>El carrito está vacío.</p>
                <?php else: ?>
                    <?php echo $mensajeCarrito; ?>
                    <form method="POST" style="margin-top: 10px;">
                        <button type="submit" name="vaciar_carrito" style="background: #ff4444; padding: 8px 15px;">
                            🗑️ Vaciar Carrito
                        </button>
                    </form>
                <?php endif; ?>
            </div>

            <!-- Formulario de preferencias -->
            <hr>
            <h3>⚙️ Preferencias de Visualización</h3>
            <form method="POST" action="gestor_productos.php">
                <div class="form-group">
                    <label for="productos_pagina">Productos por página:</label>
                    <input type="number" id="productos_pagina" name="productos_pagina" min="1" max="50" value="<?php echo $_COOKIE['productos_pagina'] ?? 10; ?>">
                </div>
                
                <div class="form-group">
                    <label for="orden">Ordenar por:</label>
                    <select id="orden" name="orden">
                        <option value="nombre" <?php echo ($_COOKIE['orden'] ?? 'nombre') === 'nombre' ? 'selected' : ''; ?>>Nombre</option>
                        <option value="precio" <?php echo ($_COOKIE['orden'] ?? 'nombre') === 'precio' ? 'selected' : ''; ?>>Precio</option>
                        <option value="categoria" <?php echo ($_COOKIE['orden'] ?? 'nombre') === 'categoria' ? 'selected' : ''; ?>>Categoría</option>
                    </select>
                </div>
                
                <button type="submit" name="guardar_preferencias">💾 Guardar Preferencias</button>
            </form>
        </div>
    </div>

    <!-- Estadísticas -->
    <div class="seccion" style="grid-column: 1 / -1; margin-top: 20px;">
        <h2>📊 Estadísticas</h2>
        <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 20px; text-align: center;">
            <div>
                <h3>Total Productos</h3>
                <p style="font-size: 2em; margin: 0;"><?php echo count($productos); ?></p>
            </div>
            <div>
                <h3>Valor Total</h3>
                <p style="font-size: 2em; margin: 0;">$<?php echo number_format($sumaTotal, 2); ?></p>
            </div>
            <div>
                <h3>En Carrito</h3>
                <p style="font-size: 2em; margin: 0;"><?php echo count($carrito); ?></p>
            </div>
            <div>
                <h3>Total Carrito</h3>
                <p style="font-size: 2em; margin: 0;">$<?php echo number_format($totalCarrito, 2); ?></p>
            </div>
        </div>
    </div>
</body>
</html>