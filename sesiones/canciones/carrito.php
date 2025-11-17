<?php
session_start();
include "datos_musica.php";

// Inicializar carrito si no existe
if (!isset($_SESSION['carrito']) || !is_array($_SESSION['carrito'])) {
    $_SESSION['carrito'] = [];
}

$carrito = $_SESSION['carrito'];

// Función para obtener las canciones del carrito con toda su información
function obtenerCancionesDelCarrito($idsCarrito, $todasLasCanciones) {
    $cancionesEnCarrito = [];
    
    foreach ($idsCarrito as $id) {
        // Buscar la canción por ID en el array de todas las canciones
        foreach ($todasLasCanciones as $cancion) {
            if ($cancion['id'] == $id) {
                $cancionesEnCarrito[] = $cancion;
                break;
            }
        }
    }
    
    return $cancionesEnCarrito;
}

function arrayATabla($array, $titulo = '') {
    if (empty($array)) return "<p>No hay canciones en el carrito</p>";
    
    $html = '';
    if ($titulo) {
        $html .= "<h3>$titulo</h3>";
    }
    
    $html .= '<table border="1" style="border-collapse: collapse; width: 100%;">';
    
    // Detectar si es array de arrays
    $esMultidimensional = is_array($array[0] ?? null);
    
    if ($esMultidimensional) {
        // Generar encabezados desde las keys del primer elemento
        $html .= '<tr>';
        foreach (array_keys($array[0]) as $header) {
            $html .= "<th style='padding: 8px; background: #f0f0f0;'>" . htmlspecialchars($header) . "</th>";
        }
        $html .= "<th style='padding: 8px; background: #f0f0f0;'>Acción</th>";
        $html .= '</tr>';
        
        // Generar filas
        foreach ($array as $fila) {
            $html .= '<tr>';
            foreach ($fila as $valor) {
                $html .= "<td style='padding: 8px;'>" . htmlspecialchars($valor) . "</td>";
            }
            // Añadir botón para eliminar del carrito
            $html .= '<td style="padding: 8px;">';
            $html .= '<form method="post" style="display: inline; margin: 0;">';
            $html .= '<input type="hidden" name="remover" value="' . htmlspecialchars($fila['id']) . '">';
            $html .= '<button type="submit" style="padding: 4px 8px; cursor: pointer; background: #ff4444; color: white; border: none;">Eliminar</button>';
            $html .= '</form>';
            $html .= '</td>';
            $html .= '</tr>';
        }
    } else {
        // Array simple (solo IDs)
        $html .= '<tr>';
        foreach ($array as $valor) {
            $html .= "<td style='padding: 8px;'>ID: " . htmlspecialchars($valor) . "</td>";
        }
        $html .= '</tr>';
    }
    
    $html .= '</table>';
    return $html;
}

// Procesar todas las acciones POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Eliminar una canción individual
    if (isset($_POST['remover'])) {
        $id_cancion = $_POST['remover'];
        $clave = array_search($id_cancion, $_SESSION['carrito']);
        
        if ($clave !== false) {
            unset($_SESSION['carrito'][$clave]);
            $_SESSION['carrito'] = array_values($_SESSION['carrito']); // Reindexar array
            $_SESSION['msg_flash'] = "Canción eliminada del carrito";
        }
    }
    
    // Vaciar todo el carrito
    if (isset($_POST['vaciar_carrito'])) {
        $_SESSION['carrito'] = [];
        $_SESSION['msg_flash'] = "Carrito vaciado correctamente";
    }
    
    header('Location: carrito.php');
    exit();
}

// Obtener las canciones completas del carrito
$cancionesEnCarrito = obtenerCancionesDelCarrito($carrito, $canciones);

// Mostrar mensajes flash
if (isset($_SESSION['msg_flash'])) {
    $mensajeFlash = $_SESSION['msg_flash'];
    unset($_SESSION['msg_flash']);
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrito de la Compra</title>
    <link rel="stylesheet" href="https://cdn.simplecss.org/simple.min.css">
</head>
<body>
    <h1>Mi Carrito</h1>

    <!-- Mensajes Flash -->
    <div id="flash-message">
        <?php if (isset($mensajeFlash)): ?>
            <p style="color: green; background: #e8f5e8; padding: 10px; border-radius: 5px;">
                <?php echo htmlspecialchars($mensajeFlash); ?>
            </p>
        <?php endif; ?>
    </div>

    <h2>Canciones en el Carrito (<?php echo count($cancionesEnCarrito); ?>)</h2>

    <?php
    echo arrayATabla($cancionesEnCarrito, "Mis Canciones Seleccionadas");
    ?>

    <!-- Resumen del carrito -->
    <div style="margin-top: 20px; padding: 15px; background: #f9f9f9; border-radius: 5px;">
        <h3>Resumen del Carrito</h3>
        <p><strong>Total de canciones:</strong> <?php echo count($cancionesEnCarrito); ?></p>
        
        <?php if (!empty($cancionesEnCarrito)): ?>
            <form method="post" style="margin-top: 10px;">
                <button type="submit" name="vaciar_carrito" 
                        onclick="return confirm('¿Estás seguro de que quieres vaciar todo el carrito?')"
                        style="padding: 8px 15px; background: #ff4444; color: white; border: none; cursor: pointer;">
                    🗑️ Vaciar Carrito Completo
                </button>
            </form>
        <?php else: ?>
            <p style="color: #666;">Tu carrito está vacío</p>
        <?php endif; ?>
    </div>

    <br>
    <a href="tienda.php">← Volver a la Tienda</a>
</body>
</html>