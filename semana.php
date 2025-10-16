
<?php
if (isset($_GET['dia'])) {
    echo "Viene el dia";
    $dia = $_GET['dia'];
} else {
    echo "no viene el día, por lo que generamos uno aleatorio";
    $dia = rand(1, 7);
}


if ($dia <= 5 && $dia >= 1) {
    echo "Dia de la semana: $dia <br>
        Es un día laborable";
}

elseif ($dia <= 7 && $dia > 5) {
    echo "Dia de la semana: $dia <br>
        No es un día laborable";
}
else 
    echo "No es un dia correcto"







?>




   

