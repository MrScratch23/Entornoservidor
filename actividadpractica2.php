<?php



/* Indicaciones
Inicialización de Variables:
Antes de procesar el formulario, inicializa todas las variables que se utilizarán para almacenar los datos de entrada del usuario. Esto ayudará a evitar errores de referencia y asegurará que las variables siempre tengan un valor..
*/ 
/*
Sanitización de Entradas:
Usa una función para limpiar los datos ingresados por el usuario. Puedes utilizar trim, stripslashes y htmlspecialchars para evitar problemas de seguridad.
*/

$nombre = isset($_POST['nombre']) ? htmlspecialchars($_POST['nombre']) : '';
$apellidos = isset($_POST['apellidos']) ? htmlspecialchars($_POST['apellidos']) : '';
// CUIDAO, html special chars da problemas con las fechas, luego va a haber que usar el valor original de nuevo, mantengo esto por seguridad por lo menos
$fecha_nacimiento = isset($_POST['fecha_nacimiento']) ? htmlspecialchars($_POST['fecha_nacimiento']) : '';
$genero = isset($_POST['genero']) ? htmlspecialchars($_POST['genero']) : '';
$curso = isset($_POST['curso']) ? htmlspecialchars($_POST['curso']) : '';
// para las preferencias hay que guardarlas en un array (varias opciones, array al canto)
$preferencias = isset($_POST['preferencias']) ? $_POST['preferencias'] : []; 
$email = isset($_POST['email']) ? htmlspecialchars($_POST['email']) : '';
// he leido que las contraseñas no necesitan special chars, se las quito a ambas
$contraseña = isset($_POST['password']) ? $_POST['password'] : ''; 
$confirmarContraseña = isset($_POST['confirmar_password']) ? $_POST['confirmar_password'] : ''; 
$comentarios = isset($_POST['comentarios']) ? htmlspecialchars($_POST['comentarios']) : ''; 
// para booleanos tampoco, hay que usar true o false
$terminos = isset($_POST['terminos']) ? true : false; 




/*

Validación de Campos:
Asegúrate de que los campos obligatorios estén completos. Si faltan, muestra un mensaje de error junto al campo correspondiente.
Para la fecha de nacimiento, verifica que la fecha sea válida y que el usuario tenga al menos 18 años. Puedes utilizar DateTime para calcular la edad.(algunas funciones relacionadas que podrías usar: date_create, date_format, date_diff
Para el email, utiliza filter_var con FILTER_VALIDATE_EMAIL para asegurarte de que tiene un formato correcto. Además, comprueba que no esté ya registrado en el archivo CSV.
*/ 

// declaro las variables de error aqui que iran luego en el html, las opcionales no las marco porque imagino que no importa si estan o no vacias
 $errorNombre = "";
    $errorApellidos = "";
    $errorFecha = "";
    $errorGenero = "";
    
    $errorEmail = "";
    $errorContraseña = "";
    $errorConfirmarContraseña = "";
    $errorTerminos = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['enviar'])) {


  if (empty($nombre)) {
    $errorNombre = "El campo es obligatorio";
  }
if (empty($apellidos)) {
    $errorApellidos = "Los apellidos son obligatorios";
  }

  // para comprobar la fecha hay que usar la original
  $fechaParaValidar = isset($_POST['fecha_nacimiento']) ? $_POST['fecha_nacimiento'] : '';
  
  if (empty($fechaParaValidar)) {
    $errorFecha = "La fecha de nacimiento es obligatoria";
  } else {

    $fechaNacimiento = DateTime::createFromFormat('Y-m-d', $fechaParaValidar);
    $fechaActual = new DateTime();
    $diferencia = date_diff($fechaNacimiento, $fechaActual);

    // date diff devuelve un objeto interval, con el Y le estoy indicando que quiero los años. Lo he buscado por internet para esta manera, parece mucho mas sencilla
    $edad = $diferencia->y;
    
    if ($edad < 18) {
      $errorFecha = "Debes tener al menos 18 años.";
    }
  }

  if (empty($genero)) {
    $errorGenero = "El genero es obligatorio.";
  }

  // primero comprobamos el email
 if (empty($email)) {
    $errorEmail = "El email es obligatorio";
} else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errorEmail = "El formato del email no es válido";
} else {
// ahora compruebo el archivo

// leeo el archivo con fopen y lo cierro con fclose, formaro solo lectura (read)
 if (file_exists('usuarios.csv')) {
        $archivo = fopen('usuarios.csv', 'r');
        while (($fila = fgetcsv($archivo)) !== FALSE) {
            // segun el codigo y la preferencia, el email es la columna 7, indice 6
            // lo que hago es comprobar que exista el indice 6 (el del email) y luego compararlo con la variable de email
            if (isset($fila[6]) && trim($fila[6]) === $email) {
                $errorEmail = "El email ya fue registrado anteriormente";
                break;
            }
        }
        fclose($archivo);
}

}

// seguimos, ahora los errores para las contraseñas

if (empty($contraseña) && empty($confirmarContraseña)) {
    $errorContraseña = "La contraseña y su confirmacion es obligatoria. ";
} elseif ($contraseña !== $confirmarContraseña) {
  
    $errorConfirmarContraseña = "Las contraseñas no coinciden.";
}



if ($terminos === false) {
    $errorTerminos = "Debes aceptar los terminos y condiciones.";
   
}

/* 
Almacenamiento de Datos:
Cuando todos los datos hayan sido validados, almacena la información en un archivo CSV. Utiliza fputcsv para facilitar la escritura de los datos.
Asegúrate de abrir el archivo en modo "a+" para que puedas agregar nuevos registros sin sobrescribir los existentes.

*/

// si todo esta correcto creamos el archivo, lo he llamado usuarios.csv, no se si querias otro nombre

// usamos los emptys que he hecho anterioramente
if (empty($errorNombre) && empty($errorApellidos) && empty($errorFecha) && 
    empty($errorGenero) && empty($errorEmail) && empty($errorContraseña) && 
    empty($errorConfirmarContraseña) && empty($errorTerminos)) {
    
    // modo +a
    $archivo = fopen('usuarios.csv', 'a+');
    
// fputs y para el archivo
    $datos = [
        $nombre,
        $apellidos,
        $fecha_nacimiento,
        $genero,
        $curso,
        // implode para transformar el array de las preferencias si las hubiese
        implode(',', $preferencias),
        $email,
        $contraseña,
        $confirmarContraseña,
        $comentarios,
        $terminos ? 'verdadero' : 'falso'
    ];
    
    

/*
Mensajes de Éxito/Error:
Una vez que los datos se han guardado correctamente en el archivo CSV, muestra un mensaje de éxito.
En caso de error, asegúrate de mostrar el mensaje correspondiente al usuario.

*/

    if (fputcsv($archivo, $datos)) {
       
        $mensajeExito = "¡Registro completado correctamente!";
    } else {
      
        $mensajeError = "Error al guardar los datos. Inténtalo de nuevo.";
    }
    
    fclose($archivo);
}

   
}


?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario de Usuario</title>
    <link rel="stylesheet" href="https://cdn.simplecss.org/simple.min.css">
    <style>
        .hidden { display: none; }
        .error { color: red; }
    </style>
</head>
<body>
    <!-- la mayoria de este codigo esta hecho con deepseek, salvo las partes de php, espero que no te importe demasiado -->
    <header>
        <h1>Formulario de usuario</h1>
    </header>
    
    <main>
        <!-- Mensajes de éxito/error -->
        <?php if (isset($mensajeExito)): ?>
            <div style="color: green; padding: 10px; border: 1px solid green; margin-bottom: 20px;">
                ✅ <?php echo $mensajeExito; ?>
            </div>
        <?php endif; ?>

        <?php if (isset($mensajeError)): ?>
            <div style="color: red; padding: 10px; border: 1px solid red; margin-bottom: 20px;">
                ❌ <?php echo $mensajeError; ?>
            </div>
        <?php endif; ?>

        <form action="" method="POST">
            <!-- Nombre -->
            <label for="nombre">Nombre</label>
            <input type="text" id="nombre" name="nombre" value="<?php echo $nombre; ?>">
            <small class="error <?php echo empty($errorNombre) ? 'hidden' : ''; ?>">
                <?php echo $errorNombre; ?>
            </small>
            
            <!-- Apellidos -->
            <label for="apellidos">Apellidos</label>
            <input type="text" id="apellidos" name="apellidos" value="<?php echo $apellidos; ?>">
            <small class="error <?php echo empty($errorApellidos) ? 'hidden' : ''; ?>">
                <?php echo $errorApellidos; ?>
            </small>
            
            <!-- Fecha Nacimiento -->
            <label for="fecha_nacimiento">Fecha Nacimiento</label>
            <input type="date" id="fecha_nacimiento" name="fecha_nacimiento" value="<?php echo $fecha_nacimiento; ?>">
            <small>dd/mm/aaaa</small>
            <small class="error <?php echo empty($errorFecha) ? 'hidden' : ''; ?>">
                <?php echo $errorFecha; ?>
            </small>
            
            <!-- Género -->
            <label>Género</label>
            <label>
                <input type="radio" name="genero" value="masculino" <?php echo ($genero == 'masculino') ? 'checked' : ''; ?>>
                Masculino
            </label>
            <label>
                <input type="radio" name="genero" value="femenino" <?php echo ($genero == 'femenino') ? 'checked' : ''; ?>>
                Femenino
            </label>
            <label>
                <input type="radio" name="genero" value="otro" <?php echo ($genero == 'otro') ? 'checked' : ''; ?>>
                Otro
            </label>
            <small class="error <?php echo empty($errorGenero) ? 'hidden' : ''; ?>">
                <?php echo $errorGenero; ?>
            </small>
            
            <!-- Curso -->
            <label for="curso">Curso</label>
            <select id="curso" name="curso">
                <option value="">Seleccione un curso</option>
                <option value="primero" <?php echo ($curso == 'primero') ? 'selected' : ''; ?>>Primero</option>
                <option value="segundo" <?php echo ($curso == 'segundo') ? 'selected' : ''; ?>>Segundo</option>
                <option value="tercero" <?php echo ($curso == 'tercero') ? 'selected' : ''; ?>>Tercero</option>
                <option value="cuarto" <?php echo ($curso == 'cuarto') ? 'selected' : ''; ?>>Cuarto</option>
            </select>
            
            <!-- Preferencias -->
            <label>Preferencias</label>
            <label>
                <input type="checkbox" name="preferencias[]" value="deportes" <?php echo in_array('deportes', $preferencias) ? 'checked' : ''; ?>>
                Deportes
            </label>
            <label>
                <input type="checkbox" name="preferencias[]" value="musica" <?php echo in_array('musica', $preferencias) ? 'checked' : ''; ?>>
                Música
            </label>
            <label>
                <input type="checkbox" name="preferencias[]" value="viajes" <?php echo in_array('viajes', $preferencias) ? 'checked' : ''; ?>>
                Viajes
            </label>
            
            <!-- Email -->
            <label for="email">Email</label>
            <input type="email" id="email" name="email" value="<?php echo $email; ?>">
            <small class="error <?php echo empty($errorEmail) ? 'hidden' : ''; ?>">
                <?php echo $errorEmail; ?>
            </small>
            
            <!-- Password -->
            <label for="password">Password</label>
            <input type="password" id="password" name="password">
            <small class="error <?php echo empty($errorContraseña) ? 'hidden' : ''; ?>">
                <?php echo $errorContraseña; ?>
            </small>
            
            <!-- Confirmar Password -->
            <label for="confirmar_password">Confirmar Password</label>
            <input type="password" id="confirmar_password" name="confirmar_password">
            <small class="error <?php echo empty($errorConfirmarContraseña) ? 'hidden' : ''; ?>">
                <?php echo $errorConfirmarContraseña; ?>
            </small>
            
            <!-- Comentarios -->
            <label for="comentarios">Comentarios</label>
            <textarea id="comentarios" name="comentarios" rows="4"><?php echo $comentarios; ?></textarea>
            
            <!-- Términos y condiciones -->
            <label>
                <input type="checkbox" name="terminos" <?php echo $terminos ? 'checked' : ''; ?>>
                Acepto los términos y condiciones
            </label>
            <small class="error <?php echo empty($errorTerminos) ? 'hidden' : ''; ?>">
                <?php echo $errorTerminos; ?>
            </small>
            
            <!-- Botones -->
            <button type="submit" name="enviar">Enviar</button>
            <button type="reset" class="secondary">Limpiar</button>
        </form>
    </main>
</body>
</html>