<?php

// podemos crear un asociativo asi, con esto va por ID en vez de por numeros
$persona = [
"nombre"=>"Pepe", 
"edad"=>"54" , 
"profesion" => "albañil" ];

echo "<pre>";
print_r($persona);
echo "</pre>";

// cambiamos el valor de nombre
$persona["nombre"]="Juan";

// para borrar elementos


?>