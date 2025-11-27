<!-- 
    Página de gestión de equipo de héroes
    Autor: P.Lluyot
    Examen-2 de DWES - Curso 2025-2026
-->

<?php

session_start();
require_once "datos.php";

// funcion util para eliminar heroe del array
function eliminarDelArray(&$array, $valor) {
    $clave = array_search($valor, $array, true);
    if ($clave !== false) {
        unset($array[$clave]);
        $array = array_values($array);
        return true;
    }
    return false;
}

    

$contadorID = 0;


$jugador = $_SESSION['usuario'];
$presupuesto = $_SESSION['presupuesto_inicial'];

if (!isset($_SESSION['usuario'])) {
    header("Location: index.php", true, 302);
    exit();
}

$arrayHeroes = HEROES;
$errores = [];
$equipoActual = $_SESSION['equipo_heroes'];
$_SESSION['totalEquipo'] = 0;



if ($_SERVER['REQUEST_METHOD'] === 'POST') {

      $id = $_POST['id_heroe'] ?? '';
  if (isset($_POST['agregar'])){
  

    if (!is_numeric($id)) {
        $errores ['id'] = "Error en el ID";
    }

    if ($id === '') {
        $errores ['id'] = "El ID no puede estar vacio.";
    }

      if (isset($_SESSION['equipo_heroes']) && in_array($id, $_SESSION['equipo_heroes'])) {
            $_SESSION['mensajeflash']= "No existe este heroe";
        }

        


    if (empty($errores)) {
        $heroe = $arrayHeroes[$id];
        array_push($_SESSION['equipo_heroes'], $heroe);
        $_SESSION['mensajeflash'] = "Heroe añadido";
        $_SESSION['presupuesto_inicial'] -= $heroe['coste'];
        $_SESSION['totalEquipo'] += $heroe['coste'];

        
 
       
    }

  }

  
  if (isset($_POST['eliminar'])){
    eliminarDelArray($_SESSION['equipo_heroes'], $id);
     $_SESSION['mensajeflash'] = "Heroe borrado.";
    }


}


?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Equipo de Héroes</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-slate-100 text-slate-800">
    <div class="container mx-auto p-4 sm:p-6 lg:p-8">
        <!-- Cabecera con datos del jugador y acciones -->
        <header class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6">
            <div>
                <h1 class="text-3xl font-bold">Panel del Jugador: <span class="text-indigo-600"><?php echo $jugador ?></span></h1>
                <p class="text-slate-500">Forma tu equipo gestionando tu presupuesto.</p>
            </div>

            <div class="flex flex-wrap gap-4 w-full sm:w-auto">
                <!-- Paneles de información rápida -->
                <div class="text-center bg-white shadow-md rounded-lg p-3 min-w-[160px]">
                    <span class="text-sm font-semibold text-slate-500">Presupuesto Restante</span>
                    <p class="text-2xl font-bold text-green-600"><?php echo $presupuesto ?> Puntos</p>
                </div>
                <div class="text-center bg-white shadow-md rounded-lg p-3">
                    <span class="text-sm font-semibold text-slate-500">Héroes</span>
                    <p class="text-2xl font-bold text-back-600">  <?php  echo isset($_SESSION['equipo_heroes']) ? count($_SESSION['equipo_heroes']) : 0;  ?>
                    </p>
                </div>
                <div class="text-center bg-white shadow-md rounded-lg p-3">
                    <span class="text-sm font-semibold text-slate-500">Coste Total</span>
                    <p class="text-2xl font-bold text-indigo-600"><?php echo $_SESSION['totalEquipo']; ?> Puntos</p>
                </div>
                <!-- Acciones principales -->
                <div class="flex flex-col gap-2">
                    <a href="analisis.php" class="text-center py-2 px-4 bg-blue-600 text-white font-semibold rounded-lg shadow-md hover:bg-blue-700">Ver Análisis</a>
                    <a href="index.php" name="reiniciar" class="text-center py-2 px-4 bg-red-600 text-white font-semibold rounded-lg shadow-md hover:bg-red-700">Reiniciar</a>
                </div>

            </div>
        </header>

        <!-- Sección de héroes reclutados y disponibles -->
        <section>
            <h2 class="text-2xl font-semibold border-b-2 border-slate-300 pb-2 mb-4">Lista de Héroes</h2>
            <!-- distintos tipos de mensaje en función si es de éxito o error -->
            <!-- <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded-md" role="alert"> -->
            <div class="bg-blue-100 border-l-4 border-blue-500 text-blue-700 p-4 mb-6 rounded-md" role="alert">
                <p> <?php
        if (isset($_SESSION['mensajeflash'])) {
            echo $_SESSION['mensajeflash'];
            unset($_SESSION['mensajeflash']);
        }
        ?></p>
            </div>

            <!-- Grid de héroes -->
            
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6 gap-4">
                 <?php foreach ($arrayHeroes as $heroe) :?>
                    <?php $contadorID ++ ?>
                <!-- Tarjeta de héroe (ejemplo1 - héroe sin incluir en la lista) -->
                 <?php 
                 $clase = "'rounded-lg shadow-xl overflow-hidden relative h-[420px] group'"; 
                    
                 if (in_array($contadorID, $_SESSION['equipo_heroes'])) {
                $clase = "'rounded-lg shadow-xl overflow-hidden relative h-[420px] group ring-4 ring-offset-2 ring-indigo-500'";
                 }

                 if ($heroe['coste'] > $presupuesto) {
                    $clase = "'rounded-lg shadow-xl overflow-hidden relative h-[420px] group'";
                 }
                 
                 ?>
                <div class=<?php echo $clase ?>>
                    <!-- ring-4 ring-offset-2 ring-indigo-500 -->
                    <img class='w-full h-full object-cover' src="img/<?php echo $heroe['imagen'] ?>" alt=<?php echo $heroe['nombre'] ?>>
                       <div class='absolute inset-0 p-3 flex flex-col justify-end text-white transition duration-300 ease-in-out'>
                        <div class='p-2 rounded-lg bg-black/40 group-hover:bg-black/50 transition duration-300'>
                            <div>
                                <h3 class='text-xl font-extrabold border-b-2 border-indigo-400 pb-1 mb-1'><?php echo $heroe['nombre'] ?></h3>
                                <p class='text-base font-medium text-indigo-200 mb-2'><?php echo $heroe['clase'] ?></p>
                            </div>
                            <div class='text-xs space-y-1 mb-3'>
                                <p><strong>Ataque: </strong><?php echo $heroe['ataque'] ?></p>
                                <p><strong>Defensa: </strong><?php echo $heroe['defensa'] ?></p>
                                <p><strong>Magia: </strong><?php echo $heroe['magia'] ?></p>
                            </div>
                            <p class='text-center font-bold text-indigo-300 text-lg mb-2'>Coste: 300</p>
                            <form method="post" action="equipo.php"> <!--completa el formulario (puedes cambiarlo si quieres pasar el id_heroe en el botón)-->
                                <input type='hidden' name='id_heroe' value=<?php echo $contadorID ?>>
                                <?php
                                $claseBoton = '<button type="submit" name="agregar" class="w-full py-1 px-3 text-white text-sm font-semibold rounded-lg shadow-md transition duration-150 bg-indigo-600 hover:bg-indigo-700" value="reclutar">Reclutar</button>';
                                 if (in_array($contadorID, $_SESSION['equipo_heroes'])) {
                                $claseBoton = '<button type="submit" name="eliminar" class="w-full py-1 px-3 bg-red-600 text-white text-sm font-semibold rounded-lg shadow-md hover:bg-red-700 transition duration-150" value="eliminar">Eliminar</button>';
                                } 
                              
                                
                                ?>
                                <?php echo $claseBoton; ?>
                            </form>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
                

    </div>
    <!-- Pie de página con autor y curso -->
    <footer class="text-center text-sm text-gray-500 mt-10">
        © 2025 P.Lluyot · Examen de DWES
    </footer>
</body>

</html>