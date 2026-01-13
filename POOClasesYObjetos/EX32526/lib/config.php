<?php

define('APP_ROOT', dirname(__DIR__));

if ($_SERVER['HTTP_HOST'] === 'localhost') {
    define('BASE_URL', '/home/DAW2/Entornoservidor/POOClasesYObjetos/EX32526');
} else {
    define('BASE_URL', '/');
}

?>