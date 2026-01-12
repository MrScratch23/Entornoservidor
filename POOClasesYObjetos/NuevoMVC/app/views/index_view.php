
<?php

var_dump($datos);

?>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Personal DWES</title>
    <!-- simple.css - Librería CSS minimalista -->
    <link rel="stylesheet" href="https://cdn.simplecss.org/simple.min.css">
</head>
<body>
    <header>
        <h1>Lista de Personal</h1>
    </header>

    <main>
        <?php if (empty($datos) || !is_array($datos)): ?>
            <p>No hay personal registrado.</p>
        <?php else: ?>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Apellidos</th>
                        <th>Edad</th>
                        <th>Puntuación</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($datos as $personal): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($personal['id'] ?? ''); ?></td>
                        <td><?php echo htmlspecialchars($personal['nombre'] ?? ''); ?></td>
                        <td><?php echo htmlspecialchars($personal['apellidos'] ?? ''); ?></td>
                        <td><?php echo htmlspecialchars($personal['edad'] ?? ''); ?></td>
                        <td><?php echo htmlspecialchars($personal['puntuacion'] ?? ''); ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </main>
</body>
</html>