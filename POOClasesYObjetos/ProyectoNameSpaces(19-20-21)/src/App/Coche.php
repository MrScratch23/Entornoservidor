<?php

namespace RDTM\App;

class Coche {

    private static int $cantidadCoches = 0;


    // constructor con propiedades promocionadas
    public function __construct(private string $marca, private string $modelo, private int $anyo = 2021){
      echo "Nuevo coche creado. \n";
      // para propiedades staticas, hay que usar self 
      self::$cantidadCoches++;
    }

    // Getters y setters magicos
    public function __get($propiedad){   
        if (property_exists($this, $propiedad)) {
           return $this->$propiedad;
        }  
        return null;
    }

    public function __set($propiedad, $valor){   
        if (property_exists($this, $propiedad)) {
            if ($propiedad === 'anyo' && $valor <=1886) {
                echo "Fecha no permitida";
                return;
            }
            $this->$propiedad = $valor;
        }  
    }
        
    // mostrar la informacion
    public function mostrarInfo() {
        echo "Marca: " . $this->marca . " - Modelo: " . $this->modelo . " - Año:" . $this->anyo . "\n"; 
    }

    public function actualizarAnyo(int $anyo) {
        $this->anyo = $anyo;
    }

    public function compararAntiguedad(Coche $otroCoche): string {
        if ($this->anyo > $otroCoche->anyo) {
            return "El {$this->marca} {$this->modelo} ({$this->anyo}) es más nuevo que el {$otroCoche->marca} {$otroCoche->modelo} ({$otroCoche->anyo})";
        } elseif ($this->anyo < $otroCoche->anyo) {
            return "El {$otroCoche->marca} {$otroCoche->modelo} ({$otroCoche->anyo}) es más nuevo que el {$this->marca} {$this->modelo} ({$this->anyo})";
        } else {
            return "Ambos coches son del mismo año ({$this->anyo})";
        }
    }

   public function __destruct(){
       // echo "El coche con marca: " . $this->marca ." -modelo: " . $this->modelo . " - año:" . $this->anyo . "HA SIDO DESTRUIDO";
        self::$cantidadCoches--;
    }
    
    public static function getTotalCoches() {
        return self::$cantidadCoches;
    }

};

/*$coche = new Coche("Volksvagen", "Passar", 2006);
echo "Total de coches: " . $coche->getTotalCoches() ;
$coche2 = new Coche("Opel Corsa", "208", 2017);
echo "Total de coches: " . $coche->getTotalCoches() ;
$coche3 = new Coche("Toyota", "Algoasin", 2009);
unset($coche3);
echo "Total de coches: " . $coche->getTotalCoches() ;

// se puede poner asi directamente
Coche::getTotalCoches();
*/


?>