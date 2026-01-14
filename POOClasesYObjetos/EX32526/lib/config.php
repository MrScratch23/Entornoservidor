<?php

define('APP_ROOT', dirname(__DIR__));

// BASE_URL debe ser la URL pública (path desde el host) — no la ruta del sistema de ficheros
if ($_SERVER['HTTP_HOST'] === 'localhost') {
    define('BASE_URL', '/php/POOClasesYObjetos/EX32526/public'); // ← ajustar según tu DocumentRoot
} else {
    define('BASE_URL', '/');
}
?>