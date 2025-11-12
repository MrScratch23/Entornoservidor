


<?php




include "funciones.php";
session_start();

$erroresMAX = 6;
$_SESSION['palabraAleatoria'] = palabraAleatoria();
$palabraAleatoria = palabraAleatoria();
$palabraAleatoria = reemplazar_palabra_guiones($palabraAleatoria);
$_SESSION['errores'] = 0;
$_SESSION['turnos'] = 0;
$turno = $_SESSION['turnos'];

$letrasUsadas = [];


?>






<!-- saved from url=(0030)https://dwes.lluyot.es/tarea3/ -->
<html><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>P.Lluyot</title>
    <link rel="stylesheet" href="./ahorcado_files/simple.min.css">
    <link rel="stylesheet" href="./ahorcado_files/ahorcado.css">
</head>

<body>
    <header>
        <h1>Juego del Ahorcado</h1>

    </header>
    <main>
        <aside>
            <table>
                <tbody><tr>
                    <th>Turno</th>
                    <td><?php
                    echo $turno;
                    ?></td>
                </tr>
                <tr>
                    <th>Letras usadas</th>
                    <td></td>
                </tr>
            </tbody></table>
            <form action="https://dwes.lluyot.es/tarea3/" method="post"><p><label for="letra">Introduce una letra:</label><input type="text" id="letra" name="letra" size="7" maxlength="1" required=""><button type="submit" name="enviar">Enviar</button></p></form>        </aside>
        <!-- imagen -->
        <img alt="Turno" src="./ahorcado_files/turno0.png">

        <h2 class="letra"><?php
        echo $palabraAleatoria;
        ?>
        </h2>        <p class="notice">
                        ¡Comienza el juego! Descubre la palabra antes de que sea demasiado tarde.            </p><form method="post" action="https://dwes.lluyot.es/tarea3/fin.php"><button type="submit">Reiniciar Juego</button></form>        <p></p>
    </main>

    <footer>
        <p>P.Lluyot</p>
    </footer>


</body></html>