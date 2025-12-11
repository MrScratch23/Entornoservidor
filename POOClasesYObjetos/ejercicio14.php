<?php

class Coche {
    // constructor con propiedades promocionadas
    public function __construct(private string $marca, private string $modelo, private int $anyo = 2021){
        
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
};

$coche = new Coche("Volksvagen", "Passar", 2006);
$coche2 = new Coche("Opel Corsa", "208", 2017);

echo $coche->compararAntiguedad($coche2);

?>