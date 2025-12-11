<?php

class Coche {
    // lo normal es ponerle el tipo de dato delante
    public string $marca='';
    public string $modelo='';
    public int $anyo=2000;


    public function mostrarInfo() {
        // no se debe hacer con echos, pero es para probarlo
        echo "Marca: " . $this->marca . " - Modelo: " . $this->modelo . " - Año:" . $this->anyo; 
    }


};

// por algun motivo intenta cogerme la clase del otro ejercicio, lo comento por el momento
/* $coche = new Coche();
$coche->marca = "Volksvagen";
$coche->modelo = "Passar";
$coche->anyo = 2006;

$coche->mostrarInfo();
*/

?>