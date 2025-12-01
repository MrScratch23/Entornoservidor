<!-- 
    Página de acceso a la aplicación
    Autor: P.Lluyot
    Examen-2 de DWES - Curso 2025-2026
-->

<?php



session_start();

if (isset($_SESSION['usuario'])) {
   session_unset();
   session_destroy();
}

require_once "datos.php";

$presupuesto = PRESUPUESTO_INICIAL;



$errores = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $nombre = htmlspecialchars(trim($_POST['nombre'])) ?? '';

    if ($nombre === '') {
        $errores['nombre'] = "El nombre no puede estar vacio.";
    }


    if (empty($errores)) {
        $_SESSION['usuario'] = $nombre;
        $_SESSION['presupuesto_inicial'] = $presupuesto;
        $_SESSION['equipo_heroes'] = [];
        header("Location: equipo.php", true, 302);
        exit();
    }


}


?>


<!DOCTYPE html>
<html lang="es" class="h-full bg-slate-100">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DWES - Acceso a Equipos de Héroes</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="h-full flex items-center justify-center">
    <div class="w-full max-w-md">
        <div class="bg-white shadow-lg rounded-xl p-8">
            <h1 class="text-4xl font-bold text-center text-slate-800 mb-2">Generador de Equipos</h1>
            <p class="text-center text-slate-500 mb-8">Introduce tu nombre para comenzar la selección</p>
            <!-- FORMULARIO PRINCIPAL: completa/cambia las propiedades del formulario -->
            <form action="index.php" method="post">
                <div>
                    <label for="estratega" class="block text-sm font-medium text-slate-700">Nombre del Jugador</label>
                    <div class="mt-1">
                        <input type="text" name="nombre" id="nombre" class="block w-full rounded-md border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm p-3 border" placeholder="Tu nombre...">
                    </div>
                </div>
                <div class="mt-6">
                    <button type="submit" class="w-full flex justify-center py-3 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Comenzar
                    </button>
                </div>
            </form>
           
            <div class='mt-4 text-red-600 text-sm text-center'> <?php if (isset($errores['nombre'])): ?>
                <br><span><?php echo $errores['nombre']; ?></span>
            <?php endif; ?></div>
        </div>
    </div>
</body>
</html>