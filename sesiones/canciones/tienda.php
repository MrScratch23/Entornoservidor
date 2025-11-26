<?php
session_start();
include "datos_musica.php";

// Inicializar carrito si no existe - FORZAR que sea array
if (!isset($_SESSION['carrito']) || !is_array($_SESSION['carrito'])) {
    $_SESSION['carrito'] = [];
}

function eliminarDelArray(&$array, $valor) {
    $clave = array_search($valor, $array, true);
    if ($clave !== false) {
        unset($array[$clave]);
        $array = array_values($array);
        return true;
    }
    return false;
}

function arrayATabla($array, $titulo = '') {
    if (empty($array)) return "<p>No hay datos</p>";
    
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
            
            // Determinar si la canción está en el carrito
            $enCarrito = in_array($fila['id'], $_SESSION['carrito']);
            
            // Añadir botón según si está en el carrito o no
            $html .= '<td style="padding: 8px;">';
            if ($enCarrito) {
                // Botón de eliminar
                $html .= '<form method="post" style="display: inline; margin: 0;">';
                $html .= '<input type="hidden" name="remover" value="' . htmlspecialchars($fila['id']) . '">';
                $html .= '<button type="submit" style="padding: 4px 8px; cursor: pointer; background: #ff6b6b; color: white;">Eliminar del carrito</button>';
                $html .= '</form>';
            } else {
                // Botón de añadir
                $html .= '<form method="post" style="display: inline; margin: 0;">';
                $html .= '<input type="hidden" name="añadir" value="' . htmlspecialchars($fila['id']) . '">';
                $html .= '<button type="submit" style="padding: 4px 8px; cursor: pointer; background: #4caf50; color: white;">Añadir al carrito</button>';
                $html .= '</form>';
            }
            $html .= '</td>';
            $html .= '</tr>';
        }
    } else {
        // Array simple
        $html .= '<tr>';
        foreach ($array as $valor) {
            $html .= "<td style='padding: 8px;'>" . htmlspecialchars($valor) . "</td>";
        }
        $html .= '</tr>';
    }
    
    $html .= '</table>';
    return $html;
}

// Procesar POST requests
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // DEBUG: Verificar el estado del carrito
    error_log("Carrito antes de procesar: " . print_r($_SESSION['carrito'], true));
    
    if (isset($_POST['añadir'])) {
        $id_cancion = $_POST['añadir'];
        
        // Asegurarnos de que el carrito es un array
        if (!is_array($_SESSION['carrito'])) {
            $_SESSION['carrito'] = [];
        }
        
        // Añadir al carrito (evitar duplicados)
        if (!in_array($id_cancion, $_SESSION['carrito'])) {
            $_SESSION['carrito'][] = $id_cancion;
            $_SESSION['msg_flash'] = "Añadida canción al carrito";
        } else {
            $_SESSION['msg_flash'] = "La canción ya está en el carrito";
        }
        
        header('Location: tienda.php'); 
        exit(); 
    }

    if (isset($_POST['remover'])) {
        $id_cancion = $_POST['remover'];
        
        // Asegurarnos de que el carrito es un array
        if (!is_array($_SESSION['carrito'])) {
            $_SESSION['carrito'] = [];
        }
        
        if (eliminarDelArray($_SESSION['carrito'], $id_cancion)) {
            $_SESSION['msg_flash'] = "Quitada canción del carrito";
        }
        header('Location: tienda.php'); 
        exit();
    }
}

// DEBUG: Verificar estado final del carrito
error_log("Carrito final: " . print_r($_SESSION['carrito'], true));
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tienda de Música</title>
    <link rel="stylesheet" href="https://cdn.simplecss.org/simple.min.css">
</head>
<body>
    <h1>Bienvenido a la Tienda de Música</h1>
    
    <div id="flash-message">
        <?php
        if (isset($_SESSION['msg_flash'])) {
            echo "<p>" . $_SESSION['msg_flash'] . "</p>";
            unset($_SESSION['msg_flash']); // Limpiar el mensaje después de mostrarlo
        }
        ?>
    </div>

    <h2>Categoría: Canciones Disponibles</h2>
    <?php
    echo arrayATabla($canciones, "Lista de canciones");  
    ?>
    
    <br>
    <a href="carrito.php">Ver mi carrito</a>
    
   
</body>
</html>