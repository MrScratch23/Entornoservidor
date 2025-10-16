<?php

$datos = array(2,4,1,6,3,7,8);
$persona = [
"nombre"=>"Pepe", 
"edad"=>"54" , 
"profesion" => "albañil" ];

// con unset eliminamos una parte
unset ($datos[3]);

// tambien podemos eliminarlo entero
unset ($persona["edad"]);


?>