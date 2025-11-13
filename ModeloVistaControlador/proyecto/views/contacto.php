<?php
// Mismo encabezado, navegación y pie de página repetidos
// El formulario aquí no enviaría un mensaje flash, sino que se auto-procesaría o iría a otro archivo.

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
   $nombre = $_POST['nombre'] ?? '';
   $mensaje = $_POST['mensaje'] ?? '';

    


    if (!empty($nombre)) {
        $_SESSION['mensaje_flash'] = "Gracias $nombre, hemos recibido tu mensaje.";
        header("Location: index.php", true, 302);
        exit();
    } else {
        $_SESSION['$mensaje_flash'] = "El campo nombre no puede estar vacio";
         header("Location: index.php", true, 302);
        exit();
    }



}



?>

        <h2>Contáctanos</h2>
        <p>Envíanos tus dudas. (Este formulario no tiene la lógica de mensajes flash centralizada).</p>

        <!-- El formulario se enviaría a sí mismo o a un archivo procesador -->
        <form action="contacto.php" method="POST" class="formulario-contacto">
            <label for="nombre">Tu nombre:</label><br>
            <input type="text" id="nombre" name="nombre" required placeholder="Ej: María"><br><br>

            <label for="mensaje">Mensaje:</label><br>
            <textarea id="mensaje" name="mensaje" rows="4" placeholder="Escribe aquí..."></textarea><br><br>

            <button type="submit">Enviar Mensaje</button>
        </form>
  