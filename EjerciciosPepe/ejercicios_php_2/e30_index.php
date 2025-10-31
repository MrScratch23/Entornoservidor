<?php
//código php
include 'e30_datos_estudiantes.php';
?>
<!DOCTYPE html>
<html lang='es'>

<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>P.Lluyot</title>
    <link rel='stylesheet' href='https://cdn.simplecss.org/simple.min.css'>
</head>

<body>
    <header>
        <h2>Listado de estudiantes</h2>
    </header>
    <main>
        <!-- código php -->
        <?php
        foreach ($estudiantes as $nombre => $notas) : ?>
            <li>
                <a href="e30_detalles.php?nombre=<?php echo urlencode($nombre); ?>">
                    <?php echo htmlspecialchars($nombre); ?>
                </a>
            </li>
        <?php endforeach; ?>

        <!-- <p class='notice'></p> -->
    </main>
    <footer>
        <p>P.Lluyot</p>
    </footer>
</body>

</html>