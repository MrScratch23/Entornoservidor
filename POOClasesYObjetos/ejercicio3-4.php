<?php

class Coche {
    // lo normal es ponerle el tipo de dato delante
    public string $marca='';
    public string $modelo='';
    public int $anyo=2000;


    // mostrar la informacion
    public function mostrarInfo() {
        // no se debe hacer con echos, pero es para probarlo
        echo "Marca: " . $this->marca . " - Modelo: " . $this->modelo . " - Año:" . $this->anyo . "\n"; 
    }

    public function actualizarAnyo(int $anyo) {
        $this->anyo = $anyo;
    }


};

/*
$coche = new Coche();
$coche->marca = "Volksvagen";
$coche->modelo = "Passar";
$coche->anyo = 2006;

$coche->mostrarInfo();

$coche2 = new Coche();
$coche2->marca = "Peugot";
$coche2->modelo = "208";
$coche2->anyo = 2016;

$coche2->mostrarInfo();
$coche2->actualizarAnyo(2017);
$coche2->mostrarInfo();
*/

?>