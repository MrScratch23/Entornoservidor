
<?php 
// creamos una funcion llamada generarTabla que reciba un numero entero y genere una tabla de ese tamaño
 
function generarTabla($numero) {

    // para validar que es un numero se usa is int
    if (!is_int($numero) || $numero == 0) return "<p>Parametro incorrecto</p>";


    
    $tabla = '<table>';
    $contador = 1;

    for ($i = 0; $i < $numero; $i++) {
        $tabla .= '<tr>';
        for ($j = 0; $j < $numero; $j++) {
            $tabla .= '<td>' . $contador . '</td>';
            $contador++;
        }
        $tabla .= '</tr>';
    }

    $tabla .= '</table>';
    return $tabla;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        th,
        td {
            border: 1px solid #000;
        }

    </style>
</head>
<body>

<?php
// llamamos a la funcion y mostramos varias tablas diferentes
echo generarTabla(3);
echo "<br>";
echo generarTabla(5);
echo "<br>";
echo generarTabla(7);
echo generarTabla("sdsdsd");



?>
    
</body>
</html>