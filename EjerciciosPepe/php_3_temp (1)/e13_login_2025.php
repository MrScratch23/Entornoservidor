<?php

/**
 * Ejercicio realizado por P.Lluyot. 2DAW
 */
//variables
$usuario = "";
$password = "";
$usuarios = [];
$mensaje = "";
$errores = [];

//generamos una función para caargar los datos en un array asociativo.
function cargarDatos()
{
    //array que devolveremos con los datos de todos los usuarios.
    $usuarios = [];
    $temp = []; // array temporal
    $archivo = 'credenciales.csv'; //archivo que contiene los usuarios.
    if (!file_exists($archivo)) return $usuarios; //salimos si no encuentra el archivo.
    $manejador = @fopen($archivo, "r");
    if ($manejador) { //si no da error al abrirlo
        while (!feof($manejador)) {
            $temp = fgetcsv($manejador);
            if ($temp == false || count($temp) < 3) continue; //si no hay datos o son menos de 3 campos
            else $usuarios[$temp[0]] = ["password" => $temp[1], "contador" => intval($temp[2])];
        }

        fclose($manejador);
    }
    return $usuarios;
}
//llamamos una función para comprobar si el usuario y password es correcto
//modificando el contador en el caso de que sea.
function comprobarUsuario(&$usuarios, $usuario, $password)
{
    if (empty($usuarios)) return false;
    if (isset($usuarios[$usuario]) && ($usuarios[$usuario]['password'] == $password) == true) {
        //añadimos un contador más
        $usuarios[$usuario]['contador']++;
        return true;
    } else return false;
}

//función que almacena los usuarios ya modificados.
function guardarDatos($usuarios)
{
    $archivo = 'credenciales.csv';
    $fichero = @fopen($archivo, "w");
    if ($fichero) {
        // $usuarios = fgetcsv($fichero);
        foreach ($usuarios as $indice => $usuario) {
            fputcsv($fichero, [$indice, $usuario['password'], $usuario['contador']]);
        }
        fclose($fichero);
    }
    return $usuarios;
}
//si se le ha dado al botón enviar.
if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['enviar'])) {

    //recuperamos los valores
    $usuario = htmlspecialchars(trim($_POST['usuario']) ?? '');
    $password = htmlspecialchars(trim($_POST['password']) ?? '');
    //validamos que no estén vacíos
    if (trim($usuario) === '') {;
        $errores['usuario'] = "El usuario es un campo requerido";
    }

    if (($password) === '')
        $errores['password'] = "El password es un campo requerido";

    if (empty($errores)) {
        //cargamos los datos de los usuarios almacenados en un array
        $usuarios = cargarDatos();
        //llamamos a una función para comprobar si las credenciales son correctas
        if (comprobarUsuario($usuarios, $usuario, $password)) {
            $mensaje = "El usuario se ha autenticado correctamente.";
            //guardamos el fichero actualizado
            guardarDatos($usuarios);
        } else
            $mensaje = "Usuario y password incorrectos!";
    }
}
?>
<!DOCTYPE html>
<html lang='es'>

<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>P.Lluyot</title>
    <link rel='stylesheet' href='https://cdn.simplecss.org/simple.min.css'>
    <style>
        .error {
            display: block;
            font-size: small;
            color: red;
        }
    </style>
</head>

<body>
    <header>
        <h2>Login</h2>
    </header>
    <main>
        <!-- código php -->
        <form action="e13_login_2025.php" method="post">
            <p>
                <label for="usuario">Usuario</label>
                <input type="text" name="usuario" id="usuario" size="20" value="<?= $usuario; ?>">
                <?php if (!empty($errores['usuario'])) echo "<span class='error'>{$errores['usuario']}</span>"; ?>

                <label for="password">Contraseña</label>
                <input type="password" name="password" id="password" size="20" value="<?= $password; ?>">
                <?php if (!empty($errores['password'])) echo "<span class='error'>{$errores['password']}</span>"; ?>

            </p>
            <input type="submit" name="enviar" value="Enviar">
        </form>
        <?php if (!empty($mensaje)) echo "<p class='notice'>$mensaje</p>"; ?>
    </main>
    <footer>
        <p>P.Lluyot</p>
    </footer>
</body>

</html>