<?php



function contador() {

    // con static conserva el valor
    static $c = 0;
    
    $c++;

echo 'El contador vale ' . $c . '<br>';
    
}
// imprime el ultimo valor sumandole uno
contador();
contador();
contador();
contador();
contador();

?>
