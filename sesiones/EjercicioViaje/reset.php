


<?php
session_start();
session_unset();
session_destroy();
header('Location: index.php');
exit;
?>



<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    
  
   <form action="index.php" method="get">
 <a href="reset.php">Reiniciar planificación</a>
   </form>

</body>
</html>