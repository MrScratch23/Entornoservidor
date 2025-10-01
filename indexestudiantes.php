<?php
include 'datos_estudiantes.php';

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php
echo '<ul>';
foreach ($estudiantes as $estudiante=>$notas) {
    echo '<li><a href="detalles.php?nombre=' . $estudiante . '">' . $estudiante . '</a></li>';
}
echo '</ul>';
?>

    
    
    
</body>
</html>