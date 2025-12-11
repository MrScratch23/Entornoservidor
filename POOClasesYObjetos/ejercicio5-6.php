<?php

class Coche {
    // lo normal es ponerle el tipo de dato delante
    public string $marca='';
    public string $modelo='';
    public int $anyo=2000;

    // constructor
    public function __construct( string $Marca, string $Modelo, int $Anyo = 2021){
        $this->marca = $Marca;
        $this->modelo = $Modelo;
        $this->anyo = $Anyo;
    }


    // mostrar la informacion
    public function mostrarInfo() {
        // no se debe hacer con echos, pero es para probarlo
        echo "Marca: " . $this->marca . " - Modelo: " . $this->modelo . " - Año:" . $this->anyo . "\n"; 
    }

    public function actualizarAnyo(int $anyo) {
        $this->anyo = $anyo;
    }


};

$coche = new Coche("Volksvagen", "Passar", 2006);


$coche->mostrarInfo();

$coche2 = new Coche("Opel Corsa", "208");

$coche2->mostrarInfo();


?>