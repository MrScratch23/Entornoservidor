<?php

use RDTM\App\Coche;
use RDTM\Lib\Utilidades;
use RDTM\Lib\MenuHTML;


spl_autoload_register(function ($clase) {
    //Definimos el prefijo que queremos quitar (tu "Vendor")
    $prefijo = 'RDTM\\';
    //Quitamos el prefijo de la clase (Pepelluyot\App\Coche -> App\Coche)
    // Usamos str_replace para borrar "Pepelluyot\" del principio
    $clase_relativa = str_replace($prefijo, '', $clase);
    //Cambiamos las barras invertidas por barras de directorio (App\Coche -> App/Coche)
    $ruta = "./src/".str_replace('\\', '/', $clase_relativa) . '.php';
    if (file_exists($ruta)) require_once $ruta;
    else die("Error: No se pudo cargar la clase $clase en la ruta $ruta");
});





/*require_once __DIR__ . "/src/App/Coche.php";
require_once __DIR__ . "/src/Lib/utilidades.php";
*/

$util = new Utilidades();
$coche = new Coche("Opel corsa", "Sarvage");

$util->saludar();
echo "\n";

$menu = new MenuHTML();
$menu->agregarOpcion("Google", "www.google.es");
$menu->agregarOpcion("Twitter", "www.twitter.com")

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>

<?php
echo $menu->mostrarHorizontal();
?>
    
</body>
</html>