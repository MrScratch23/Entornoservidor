<?php

class Coche {

   

    // constructor, puedes declarar el private ya mismo en el constructor
    public function __construct( private string $Marca, private string $Modelo, private int $Anyo = 2021){
        $this->marca = $Marca;
        $this->modelo = $Modelo;
        $this->anyo = $Anyo;
    }



    /* public function getMarca() {
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
         */

    // Getters y setters magicos
    public function __get($propiedad){   
        if (property_exists($this, $propiedad)) {
           return $this->propiedad;
        }  
    }

     public function __set($propiedad, $valor){   
        if (property_exists($this, $propiedad)) {
            if ($propiedad === 'anyo' && $valor <=1886) {
                echo "Fecha no permitida";
            }
            $this->propiedad = $valor;
        }  
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
// con getters magicos se pondria asi
echo $coche2->anyo;
echo "\n";
echo $coche->marca;
echo "\n";
echo $coche->modelo;
echo "\n";
echo $coche->anyo;

// con setters asi, primero la propiedad, luego le cambiamos
echo $coche->marca ="Nueva Marca";
echo $coche->marca;

?>