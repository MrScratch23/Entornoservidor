<?php

// pagina simple para borrar
session_start();




session_unset();
session_destroy();

header("Location: index.php");
exit();
?>