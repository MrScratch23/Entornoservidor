<?php

session_start();

define('APP_ROOT', dirname(__DIR__));


$pagina = $_GET['p'] ?? 'inicio';

$paginas_permitidas= ['inicio', 'nosotros', 'contacto'];


if (in_array($pagina, $paginas_permitidas)) {
    
include APP_ROOT . '/includes/header.php';

// 2. Contenido (Sube un nivel)
include APP_ROOT . "/views/{$pagina}.php";

// 3. Pie (Sube un nivel)
include APP_ROOT . '/includes/footer.php'; 
} else {

header("HTTP/1.0 404 Not Found");

include APP_ROOT . "/views/404.php";

}

if (isset($_SESSION['mensaje_flash'])) {
    $mensaje = $_SESSION['mensaje_flash'];
    unset($_SESSION['mensaje_flash']);
}




?>