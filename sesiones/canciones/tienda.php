
<?php
session_start();
include "datos_musica.php";


function eliminarDelArray(&$array, $valor) {
    $clave = array_search($valor, $array, true);
    if ($clave !== false) {
        unset($array[$clave]);
        $array = array_values($array);
        return true;
    }
    return false;
}




function mostrarTabla($canciones) {
    $tablaHTML = "<table>
    <thead>
        <tr>
            <th>ID Canción</th>
            <th>Título</th>
            <th>Artista</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>";

    foreach ($canciones as $cancion) {
        $tablaHTML .= "<tr>
                    <td>{$cancion['id']}</td>
                    <td>{$cancion['titulo']}</td>
                    <td>{$cancion['artista']}</td>
                    <td>
                        <form action='tienda.php' method='POST'>
                            <button type='submit' style='color: blue' name='añadir' value='{$cancion['id']}'>Agregar Canción</button>
                            <button type='submit' name='remover' style='color: red' value='{$cancion['id']}'>Eliminar Canción</button>
                        </form>
                    </td>
                   </tr>";
    }

    $tablaHTML .= "</tbody>
              </table>";

    return $tablaHTML; 
}



if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $carrito = [];

    if (isset($_POST['añadir'])) {
    $id_cancion = $_POST['añadir'];
    $carrito = $id_cancion;

    $_SESSION['carrito'] = $carrito;
    $_SESSION['msg_flash'] = "Añadida cancion al carrito";
    header('Location: tienda.php'); 
    exit(); 
}

if (isset($_POST['remover'])) {
    $id_cancion = $_POST['remover'];
    eliminarDelArray($carrito, $id_cancion);
    $_SESSION_['carrito'] = $carrito;
     $_SESSION['msg_flash'] = "Quitada cancion del carrito";
    header('Location: tienda.php'); 
    exit();
}

}




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
        echo $_SESSION['msg_flash'];
    }
    ?>
    </div>

    <h2>Categoría: Canciones Disponibles</h2>
    <?php
    echo mostrarTabla($canciones);  
    
    ?>
    
  
   

    <br>
    <a href="carrito.php">Ver mi carrito</a>
</body>
</html>
