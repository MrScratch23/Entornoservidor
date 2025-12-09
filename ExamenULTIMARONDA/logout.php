<?php
session_start();
session_unset();
session_destroy();

// por si se intenta entrar directamente, redirigir
if (!isset($_SESSION['usuario'])) {
    header("Location: login.php", true, 302);
}

header("Location: login.php", true, 302);
exit();

?>