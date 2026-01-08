<?php

spl_autoload_register(function ($clase) {
   //Definimos el prefijo que queremos quitar (tu "Vendor")
   $prefijo = 'enrutador\\';

   //Quitamos el prefijo de la clase (enrutador\App\Coche -> App\Coche)
   // Usamos str_replace para borrar "enrutador\" del principio
   $clase_relativa = str_replace($prefijo, '', $clase);

   //Cambiamos las barras invertidas por barras de directorio (App\Coche -> App/Coche)
   $ruta = "../" . str_replace('\\', '/', $clase_relativa) . '.php';

   if (file_exists($ruta)) require_once $ruta;
   else die("Error: No se pudo cargar la clase $clase en la ruta $ruta");
});


?>