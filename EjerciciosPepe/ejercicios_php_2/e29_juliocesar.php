<?php
$mensaje = "";
$archivo = "cesar.txt";

//funcion que cifra un texto con el cifrado de Julio Cesar
function cifradoCesar($texto, $numero)
{
    $resultado = "";
    $cadena = "abcdefghijklmnñopqrstuvwxyz";
    $cadenaM = "ABCDEFGHIJKLMNÑOPQRSTUVWXYZ";
    //$cadena_mayus = strtoupper($cadena);
    $longitud = mb_strlen($cadena);
    //convertimos el texto en array
    $arr_cadena_m = mb_str_split($cadena);
    $arr_cadena_M = mb_str_split($cadenaM);
    $arr_texto = mb_str_split($texto);
    //recorremos el array del texto
    foreach ($arr_texto as $caracter) {
        //miramos si el caracter está en uno de los arrays
        if (in_array($caracter, $arr_cadena_m) || in_array($caracter, $arr_cadena_M)) {
            //miramos si el caracter es mayúsculas o minúsculas
            if (ctype_lower($caracter)) $arr_cadena = $arr_cadena_m;
            else $arr_cadena = $arr_cadena_M;
            //buscamos el indice del caracter en la cadena
            $indice = array_search($caracter, $arr_cadena);
            //si no lo encuentra, puede ser mayúsculas
            $nuevoIndice = ($indice + $numero) % $longitud;
            if ($nuevoIndice < 0) $nuevoIndice += $longitud;
            $resultado .= $arr_cadena[$nuevoIndice];
        } //en otro caso
        else {
            $resultado .= $caracter;
        }
    }
    return $resultado;
}
//devuelve true si se ha almacenado correctamente y false en caso contrario
function guardarArchivo($texto)
{
    $archivo = "cesar.txt";
    //abrimos el archivo en modo append
    $manejador = @fopen($archivo, "a");
    if ($manejador) {
        //escribimos el texto en el archivo
        fwrite($manejador, $texto . "\n");
        //cerramos el archivo
        fclose($manejador);
        return true;
    } else {
        return false;
    }
}

//recuperamos los valores del formulario
if ($_SERVER['REQUEST_METHOD'] === "POST") {
    $texto = $_POST['texto'] ?? "";
    $numero = $_POST['numero'] ?? "";
    $guardar = isset($_POST['guardar']) ? true : false;
    //validamos si el texto está vacío
    if (trim($texto)==='') {
        $mensaje = "El texto no puede estar vacío";
    } elseif (!is_numeric($numero) || intval($numero) != $numero) {
        $mensaje = "El número debe ser un entero";
    } elseif ($numero == 0) {
        $mensaje = "El número no debe ser cero";
    } else {
        //llamamos a la funcion de cifrado
        $mensaje = cifradoCesar($texto, $numero);
        $mensaje = "<b>Texto cifrado:</b><br>$mensaje";
        //si nos piden guardar en archivo
        if ($guardar){
            if (guardarArchivo($mensaje))
                $mensaje .= "<br><i>El texto se ha guardado correctamente en el archivo</i>";
            else 
                $mensaje .= "<br><i>No se ha podido guardar el texto en el archivo</i>";
        }
    }
} ?>
<!DOCTYPE html>
<html lang='es'>

<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>P.Lluyot</title>
    <link rel='stylesheet' href='https://cdn.simplecss.org/simple.min.css'>
</head>

<body>
    <header>
        <h2>Cifrado de Julio César</h2>
    </header>
    <main>
        <form method="post">
            <p><label for="texto">Introduce un texto:</label>
                <input type="text" id="texto" name="texto" size="50" value="<?= htmlspecialchars($texto ?? "") ?>">
            </p>
            <p><label for="numero">Introduce un número:</label>
                <input type="number" id="numero" name="numero" value="<?= htmlspecialchars($numero ?? "") ?>">
            </p>
            <p><input type="checkbox" id="guardar" name="guardar" value="1">
                <label for="guardar">Guardar en archivo</label>
            </p>
            <p><input type="submit" value="Cifrar"></p>
        </form>
        <!-- código php -->
        <?php
        if (!empty($mensaje))  echo "<p class='notice'>$mensaje</p>";
        ?>
    </main>
    <footer>
        <p>P.Lluyot</p>
    </footer>
</body>

</html>