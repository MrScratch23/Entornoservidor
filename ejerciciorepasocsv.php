<?php
$usuario = "";
$password = "";
$contador = 0;
$errores = [
    "usuario" => "",
    "password" => "",
];
$mensaje = "";



if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $usuario = isset($_POST['nombre']) ? htmlspecialchars(trim($_POST['nombre'])) : '';
    $password = isset($_POST['password']) ? htmlspecialchars($_POST['password']) : '';


    if (empty($usuario)) {
        $errores['usuario'] = "El usuario no puede estar vacio";
    }

    if (empty($password)) {
        $errores['password'] = "El password no puede estar vacio";
    }



    // comprobar que existe el usuario
    // y verificar que es la misma pw

    if (empty($errores)) {

        if (file_exists("credenciales.csv")) {
            $manejador = fopen("credenciales.csv", "r");
            while (($datos = fgetcsv($manejador)) !== false) {

                if ($datos[0] !== $usuario) {
                    $errores['usuario'] = "El usuario no existe";
                    break;
                }
                if ($datos[0] === $usuario) {
                    if ($datos[1] !== $password) {
                        $errores["password"] = "Contraseña incorrecta";
                        break;
                    } else {
                        $contador++;
                    }
                }
            }
            fclose($manejador);
        }
    }

    if (empty($errores)) {
        $manejador = fopen("credenciales.csv", "w");

        $datos = [
            $nombre,
            $password,
            $contador
        ];

        fputcsv($manejador, $datos);

        fclose($manejador);
        $mensaje = "Contador aumentado correctamente.";
    } else {
        $mensaje = "Algo salio mal.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Guardar Credenciales</title>
    <link rel="stylesheet" href="https://cdn.simplecss.org/simple.min.css">
    <style>
        span.error {
            color: red;
            font-size: 0.9em;
            display: block;
            margin-bottom: 10px;
        }
        span.hidden {
            display: none;
        }
    </style>
</head>

<body>
    <h2>Formulario de Inicio de Sesión</h2>

    <form action="" method="post">
        <label for="nombre">Nombre:</label>
        <input type="text" id="nombre" name="nombre" value="<?= htmlspecialchars($usuario) ?>">
        <span class="error <?= empty($errores['usuario']) ? 'hidden' : ''; ?>">
            <?= $errores['usuario']; ?>
        </span>

        <label for="password">Contraseña:</label>
        <input type="password" id="password" name="password" value="<?= htmlspecialchars($password) ?>">
        <span class="error <?= empty($errores['password']) ? 'hidden' : ''; ?>">
            <?= $errores['password']; ?>
        </span>

        <input type="submit" value="Enviar">
    </form>

    <?php if (!empty($mensaje)): ?>
        <p class="notice"><?= htmlspecialchars($mensaje) ?></p>
    <?php endif; ?>
</body>
</html>