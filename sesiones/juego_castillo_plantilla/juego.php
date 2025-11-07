<?php
    session_start();
    // lista personajes
    $personajes = [
    'nombre' => [
        'Sir Montague', 'Lady Rowena', 'Milo el Mudo', 'Griselda la Roja',
        'Hugo el Herrero', 'Tilda la Panadera', 'Fray Martín', 'Doña Beatriz',
        'Iñigo de Valverde', 'Aldara la Curandera', 'Roldán el Juglar', 'Gunnar el Mercenario',
        'Catalina la Mercader', 'Bruno el Carpintero', 'Sofía la Herbolaria', 'Lope el Mensajero'
    ],
    'profesion' => [
        'panadero', 'mercader', 'juglar', 'espía', 'heraldo',
        'herrero', 'soldado', 'carpintero', 'médico', 'armero',
        'agricultor', 'monje', 'curandera', 'cazador', 'tabernero',
        'trovador', 'guardia', 'albañil', 'campesino', 'pregonero'
    ],
    'motivo' => [
        'trae pan para la cocina real',
        'desea comerciar con los nobles',
        'quiere cantar una balada',
        'busca refugio de una tormenta',
        'tiene un mensaje urgente del rey',
        'viene a ofrecer sus servicios de herrería',
        'requiere atención médica para un familiar',
        'trae tablones para reparar la puerta norte',
        'quiere vender hierbas y ungüentos',
        'trae víveres desde la aldea vecina',
        'dice haber visto bandidos cerca del puente',
        'pide acceso al archivo para investigar linajes',
        'trae una carta sellada para el castellano',
        'busca trabajo como centinela',
        'viene a entregar un tributo atrasado',
        'dice que persiguen lobos su ganado',
        'trae noticias de un convoy retrasado',
        'quiere audiencia para proponer un trato',
        'viene a bendecir la capilla del castillo',
        'reclama una deuda con la armería'
    ]
    ];



    if (!isset($_SESSION['usuario'])) {
        header("Location:index.php", true, 302);
        exit();
    }



 $indiceNombre = array_rand($personajes['nombre']);
$indiceProfesion = array_rand($personajes['profesion']);
$indiceMotivo = array_rand($personajes['motivo']);

// si no hay personaje guardado, generamos uno nuevo
if (!isset($_SESSION['personaje'])) {
    $_SESSION['personaje'] = [
        'nombre' => $personajes['nombre'][$indiceNombre],
'profesion' => $personajes['profesion'][$indiceProfesion],
'motivo' => $personajes['motivo'][$indiceMotivo],
'impostor' => rand(0, 1)
    ];
}

$personaje = $_SESSION['personaje'];







    // recuperamos las sessiones anteriores
    $puntos=  $_SESSION['puntos'];
    $aciertos= $_SESSION['aciertos'];
    $fallos= $_SESSION['fallos'];
    $turnos = $_SESSION['turnos'];
    
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['accion'])) {
        $usuario = $_SESSION['usuario'];
        $accion = $_POST['accion'] ?? '';

        if ($accion === "pasar" && $personaje['impostor'] === 1) {
            $_SESSION['puntos']-=5;
            $_SESSION['fallos']++;
            $_SESSION['mensajeError'] = "El personaje era un amongus";
        }
        if ($accion === "pasar" && $personaje['impostor'] === 0) {
            $_SESSION['puntos']+=10;
             $_SESSION['aciertos']++;
            $_SESSION['mensajeExito'] = "El personaje no era un impostor, diez puntos pa ti.";
        }
      
        if ($accion === "rechazar" && $personaje['impostor']===1) {
            $_SESSION['puntos']+=10;
            $_SESSION['aciertos']++;
          $_SESSION['mensajeExito'] = "El personaje era impostor, diez puntos pa ti.";
        }
        if ($accion === "rechazar" && $personaje['impostor']===0) {
            $_SESSION['fallos']++;
            $_SESSION['puntos']-=5;
          $_SESSION['mensajeError'] = "El personaje no era un impostor,";
        }

        $_SESSION['turnos']++;

          if ($_SESSION['turnos']>5) {
        header("Location:fin.php");
        exit();
    }
        
// hay que generar otro personaje para el turno siguiente

$_SESSION['personaje'] = [
    'nombre' => $personajes['nombre'][array_rand($personajes['nombre'])],
    'profesion' => $personajes['profesion'][array_rand($personajes['profesion'])],
    'motivo' => $personajes['motivo'][array_rand($personajes['motivo'])],
    'impostor' => rand(0, 1)
];


// hay que recargar la pagina
header("Location:juego.php", true, 302);
exit();
    
    }
    
$mensajeExito = $_SESSION['mensajeExito'] ?? "";
$mensajeError = $_SESSION['mensajeError'] ?? "";


  // hay que borrar los mensajes para no repetirlos
  unset($_SESSION['mensajeExito']);
  unset($_SESSION['mensajeError']);


?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Turno <?= htmlspecialchars($turno) ?></title>
    <link rel="stylesheet" href="css/estilos.css">
</head>

<body>
    <h1>Puertas del castillo</h1>
    <!-- Tabla de estadísticas del juego -->
    <table class="stats-table">
        <tr>
            <th>TURNO</th>
            <th>Puntos</th>
            <th>Aciertos</th>
            <th>Fallos</th>

        </tr>
        <tr>
            <td><?php
            echo $turnos;
             ?> / 5</td>
            <td>
                <?php
               echo $puntos;
                ?>
            </td>
            <td>
            <?php
            echo $aciertos;
            ?>

            </td>
            <td>
               <?php
               echo $fallos;
               ?> 
            </td>
        </tr>
    </table>
    <h2>Personaje</h2>

    <table class="datos-table">
        <tr>
            <th>Nombre</th>
            <td>
                <?php
                echo $personaje['nombre'];
                ?>
            </td>
        </tr>
        <tr>
            <th>Profesión</th>
            <td>
                <?php
                echo $personaje['profesion'];
                ?>
            </td>
        </tr>
        <tr>
            <th>Motivo</th>
            <td>
                <?php
                echo $personaje['motivo'];
                ?>
            </td>
        </tr>
    </table>

    <form method="post" action="juego.php">
        <button name="accion" value="pasar">Dejar pasar</button>
        <button name="accion" value="rechazar">Rechazar entrada</button>
    </form>

    <p class="ok"><?php
    echo $mensajeError;
    ?></p>
    <p class="ok">
        <?php
        echo $mensajeExito;
        ?>
    </p>

</body>

</html>