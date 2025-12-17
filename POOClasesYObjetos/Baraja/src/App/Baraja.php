<?php

namespace Pepelluyot\App;

class Baraja {
    private array $palos = ["Oros", "Copas", "Espadas", "Bastos"];
    private array $numeros = [1, 2, 3, 4, 5, 6, 7, "Sota", "Caballo", "Rey"];
    private array $cartas = [];

    private function generarBaraja() {
        foreach ($this->palos as $palo) {
            foreach ($this->numeros as $numero) {
                $this->cartas[] = [
                    "palo" => $palo,
                    "numero" => "$numero",
                    "descripcion" => $numero . ' de ' . $palo  
                ];
            }
        }
    }

    public function __construct() {
        $this->generarBaraja();
    }

    public function mostrarBaraja() {
        $html = "";
       
        
        foreach ($this->cartas as $carta) {
            $html .= "<p>" . $carta['descripcion']. "</p><br>";
        }
        
        ;
        return $html;
    }

    public function mezclar() {
        shuffle($this->cartas);
    }

    public function contarCartas() {
        return count($this->cartas); 
    }
}

$baraja = new Baraja();
$baraja->mezclar();
$barajaEntera = $baraja->mostrarBaraja();
$totalCartas = $baraja->contarCartas();

echo $barajaEntera;
echo $totalCartas;

?>

