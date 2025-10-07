<?php


$numero1 = trim($_POST['numero1']) ?? '';
$numero2 = trim($_POST['numero2']) ?? '';
$solucion = trim($_POST['operacion']) ?? '';
$mensaje = "";


if ($numero1 === "" || $numero2 === "") {
    $mensaje = "Los campos no deben estar vacíos";
} else {
    // hay que convertir los numeros
    $num1 = (float)$numero1;
    $num2 = (float)$numero2;

    if ($solucion === "sumar") {
        $resultado = $num1 + $num2;
        $mensaje = "Resultado: " . $resultado;
    }

    if ($solucion === "restar") {
        $resultado = $num1 - $num2;
        $mensaje = "Resultado: " . $resultado;
    }

    if ($solucion === "multiplicar") {
        $resultado = $num1 * $num2;
        $mensaje = "Resultado: " . $resultado;
    }

    if ($solucion === "dividir") {
        if ($num2 == 0) {
            $mensaje = "No se permite la división por cero";
        } else {
            $resultado = $num1 / $num2;
            $mensaje = "Resultado: " . $resultado;
        }
    }
}
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Calculadora</title>
</head>

<body>

    <h1>Calculadora</h1>

    <form method="POST" action="<?= htmlspecialchars($_SERVER['PHP_SELF']) ?>">
        <label for="numero1">Numero 1:</label>
        <input type="text" name="numero1" id="numero1" value="<?= htmlspecialchars($numero1) ?>" required />
        <br><br>

        <label for="numero2">Numero 2:</label>
        <input type="text" name="numero2" id="numero2" value="<?= htmlspecialchars($numero2) ?>" required />
        <br><br>


        <input type="submit" value="Calcular">

        <select name="operacion" id="operacion">
            <option value="sumar">+</option>
            <option value="restar">-</option>
            <option value="multiplicar">x</option>
            <option value="dividir">/</option>
        </select>

        </input>
    </form>
    <?= $mensaje ?>

</body>

</html>