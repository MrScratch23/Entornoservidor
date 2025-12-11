<?php

class Coche {
    // lo normal es ponerle el tipo de dato delante
    private string $marca='';
    private string $modelo='';
    public int $anyo=2000;

    // constructor
    public function __construct( string $Marca, string $Modelo, int $Anyo = 2021){
        $this->marca = $Marca;
        $this->modelo = $Modelo;
        $this->anyo = $Anyo;
    }


    // GETTERS Y SETTERS
    public function getMarca() {
        return $this->marca;
    }

     public function getModelo() {
        return $this->modelo;
    }

     public function getAnyo() {
        return $this->anyo;
    }

  public function setMarca(string $marca) {
         $this->marca;
    }

     public function setModelo(string $modelo) {
        $this->modelo;
    }

     public function setAnyo(int $anyo) {
         $this->anyo;
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


// $coche->mostrarInfo();

$coche2 = new Coche("Opel Corsa", "208");

// $coche2->mostrarInfo();

echo $coche2->anyo;
// puedes cambiar directamente las propiedades si estan public, no es recomendable
// echo $coche2->anyo = 2004;
// asi que es mejor poneorlo private
echo "\n";
echo $coche->getMarca();
echo "\n";
echo $coche->getModelo();
echo "\n";
echo $coche->getAnyo();


?>