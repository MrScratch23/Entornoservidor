<?php
// inicializar la sesion
session_start();
// ahora nos la cargamos, unset y destroy
session_unset();
session_destroy();
header("Location:login.php", true, 302);
exit();
?>