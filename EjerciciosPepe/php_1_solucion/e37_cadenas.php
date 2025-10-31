<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadenas</title>
</head>

<body>
    <?php
    // Definir cadena original
    $frase = "PHP es un lenguaje divertido y poderoso.";

    // Reemplazar "divertido" por "fácil"
    $nuevaFrase = str_replace("divertido", "fácil", $frase);

      // Mostrar ambas frases
      echo "Frase original: " . $frase . "<br>";
      echo "Frase modificada: " . $nuevaFrase . "<br>";
  
      // Reemplazar múltiples palabras
      $fraseModificada = str_replace(
          ["PHP", "poderoso"],
          ["JavaScript", "versátil"],
          $frase
      );
  
      // Mostrar frase modificada
      echo "Frase con múltiples cambios: " . $fraseModificada;
      ?>

</body>

</html>