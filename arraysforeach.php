<?php
$datos = array(2,4,1,6,3,7,8);

foreach ($datos as $dato) {
    echo $dato. "<br>";
}

$persona = [
"nombre"=>"Pepe", 
"edad"=>"54" , 
"profesion" => "albañil" ];

foreach ($persona as $valor) {
    echo $valor. "<br>";
}

// usando la clave

foreach ($persona as $clave=>$valor) {
    echo $clave. ": ".$valor."<br>";
}


?>