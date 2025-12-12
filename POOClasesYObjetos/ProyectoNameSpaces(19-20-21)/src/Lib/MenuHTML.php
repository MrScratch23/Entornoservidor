<?php

namespace RDTM\Lib;


class MenuHTML {

    private array $opciones = [];
    


      public function agregarOpcion(string $titulo, string $enlace) {
        
        $this->opciones[] = [
            "titulo" => $titulo,
            "enlace" => $enlace,
        ];
    }

     public function mostrarHorizontal() {
        $html = '';
        
        foreach ($this->opciones as $opcion) {
       
            $html .= '<a href="' . $opcion['enlace'] . '"> - ' . $opcion['titulo'] . '</a>';
        }
        
        return $html;
    }


}




?>