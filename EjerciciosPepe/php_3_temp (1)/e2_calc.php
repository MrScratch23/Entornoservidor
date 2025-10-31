<?php
$errores = [];
$numero1 = "";
$numero2 = "";
$resultado = "";
$mensaje = "";

//comprobamos el método del formulario
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    // 1) recogida y saneado de datos
    $numero1 = trim($_POST['numero1'] ?? "");
    $numero2 = trim($_POST['numero2'] ?? "");
    $operacion = $_POST['operacion'] ?? "";

    // 2) validación de datos
    if ($numero1 === "" || $numero2 === "") {
        $errores[] = "Debe introducir ambos números.";
    } elseif (!is_numeric($numero1) || !is_numeric($numero2)) {
        $errores[] = "Los valores deben ser numéricos.";
    } elseif ($operacion == "/" && floatval($numero2) == 0) {
        $errores[] = "No se puede dividir entre cero.";
    }
    // 3) Procesamiento solo si no hay errores
    if (empty($errores)) {
        $n1 = floatval($numero1);
        $n2 = floatval($numero2);
        // Realizamos la operación según el operador seleccionado
        switch ($operacion) {
            case '+':
                $resultado = $n1 + $n2;
                break;
            case '-':
                $resultado = $n1 - $n2;
                break;
            case '*':
                $resultado = $n1 * $n2;
                break;
            case '/':
                $resultado = $n1 / $n2;
                break;
        }
        $mensaje = "Resultado: $numero1 $operacion $numero2 = $resultado";
    }
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calculadora</title>
    <link rel="stylesheet" href="https://cdn.simplecss.org/simple.css">
</head>

<body>

    <header>
        <h3>Calculadora</h3>
    </header>
    <main>
        <form name="frmcalc" action="e2_calc.php" method="post">
            <p>
                <label for="numero1">Número 1:</label>
                <input type="number" step="any" name="numero1" id="numero1" placeholder="introduce el primer número" value="<?= htmlspecialchars($numero1); ?>" required>
                <label for="numero2">Número 2:</label>
                <input type="number" name="numero2" id="numero2" placeholder="introduce el segundo número" value="<?= htmlspecialchars($numero2); ?>" required>

            </p>
            <input type="submit" name="operacion" value="+">
            <input type="submit" name="operacion" value="-">
            <input type="submit" name="operacion" value="*">
            <input type="submit" name="operacion" value="/">
        </form>
        <?php
        if (!empty($errores)): ?>
            <p class='notice'>
                <?php foreach ($errores as $e): ?>
                    <?= htmlspecialchars($e) ?><br>
                <?php endforeach; ?>
            </ul>
            </p>
        <?php
        elseif (!empty($mensaje)): ?>
            <p class='notice'><?= htmlspecialchars($mensaje); ?></p>
        <?php endif; ?>
    </main>

</body>

</html>