"use strict";
// --- CONTENIDO GUÍA PHP --- //
const data = [
  {
    titulo: "Arrays en PHP",
    contenido: [
      ["array()", '$colores = ["Rojo","Verde","Azul"];', "Crea un array simple (indexado)."],
      ["Array asociativo", '$reserva = ["nombre"=>"Luis", "personas"=>4];', "Usa claves personalizadas."],
      ["Array multidimensional", '$reservas = [ ["nombre"=>"Luis"], ["nombre"=>"Ana"] ];', "Arrays dentro de arrays."],
      ["foreach", 'foreach ($reservas as $r) { echo $r["nombre"]; }', "Recorre un array completo."],
      ["print_r()", 'print_r($reservas);', "Muestra la estructura de un array."],
      ["count()", 'count($reservas);', "Cuenta elementos del array."],
      ["array_sum()", 'array_sum([1,2,3]);', "Suma valores numéricos."],
      ["implode()", 'implode(", ", $preferencias);', "Convierte un array en texto."],
      ["in_array()", 'in_array("musica", $preferencias);', "Busca un valor dentro del array."],
      ["isset()", 'isset($reserva["nombre"]);', "Comprueba si existe una clave."],
      ["empty()", 'empty($reservas);', "Comprueba si un array está vacío."],
      ["ucfirst()", 'ucfirst("musica");', "Primera letra en mayúscula."]
    ]
  },
  {
    titulo: "Ficheros en PHP",
    contenido: [
      // --- APERTURA DE FICHEROS (fopen) ---
      ["fopen() - r", '$f = fopen("archivo.txt", "r");', "Solo lectura (error si no existe)."],
      ["fopen() - r+", '$f = fopen("archivo.txt", "r+");', "Leer y escribir (no crea archivo)."],
      ["fopen() - w", '$f = fopen("archivo.txt", "w");', "Escritura (sobrescribe o crea nuevo)."],
      ["fopen() - w+", '$f = fopen("archivo.txt", "w+");', "Leer y escribir (sobrescribe)."],
      ["fopen() - a", '$f = fopen("archivo.txt", "a");', "Añadir al final (no borra)."],
      ["fopen() - a+", '$f = fopen("archivo.txt", "a+");', "Leer y añadir al final."],
      ["fopen() - x", '$f = fopen("archivo.txt", "x");', "Crear nuevo (error si ya existe)."],

      // --- LECTURA / ESCRITURA ---
      ["fgets()", '$linea = fgets($f);', "Lee una línea."],
      ["fread()", 'fread($f, filesize("archivo.txt"));', "Lee todo o X bytes."],
      ["fwrite()", 'fwrite($f, "Texto");', "Escribe texto."],
      ["feof()", 'while(!feof($f)) { ... }', "Fin de archivo."],
      ["fclose()", 'fclose($f);', "Cierra archivo."],

      // --- MÉTODOS DIRECTOS ---
      ["file_get_contents()", 'file_get_contents("archivo.txt");', "Lee todo el archivo."],
      ["file_put_contents()", 'file_put_contents("archivo.txt", "Texto");', "Escribe (sobrescribe)."],
      ["file_put_contents + FILE_APPEND", 'file_put_contents("archivo.txt", "Texto", FILE_APPEND);', "Añade sin borrar."],
      ["file()", '$lineas = file("archivo.txt");', "Devuelve array por líneas."],
      ["readfile()", 'readfile("archivo.txt");', "Lee y muestra directamente."],

      // --- CSV UTILES ---
      ["fgetcsv()", '$datos = fgetcsv($f);', "Lee línea CSV como array."],
      ["fputcsv()", 'fputcsv($f, $array);', "Escribe array en CSV."],

      // --- ARCHIVOS Y DIRECTORIOS ---
      ["unlink()", 'unlink("archivo.txt");', "Elimina archivo."],
      ["rename()", 'rename("viejo.txt", "nuevo.txt");', "Renombra o mueve archivo."],
      ["copy()", 'copy("origen.txt", "copia.txt");', "Copia archivo."],
      ["scandir()", '$archivos = scandir("carpeta/");', "Lista archivos de un directorio."],
      ["filesize()", 'filesize("archivo.txt");', "Tamaño en bytes."],
      ["chmod()", 'chmod("archivo.txt", 0644);', "Permisos de archivo."],
      ["touch()", 'touch("nuevo.txt");', "Crea archivo o modifica fecha."],
      ["pathinfo()", 'pathinfo("archivo.txt");', "Devuelve ruta, nombre y extensión."],
      ["basename()", 'basename("ruta/archivo.txt");', "Solo el nombre del archivo."],
      ["file_exists()", 'file_exists("archivo.txt");', "Comprueba si existe."]

      // ✅ SUBIDA DE ARCHIVOS Y TEMPORALES
    ]
  },
  {
    titulo: "Subida de archivos ($_FILES)",
    contenido: [
      ["$_FILES", '$_FILES["fichero"]["name"];', "Nombre original del archivo."],
      ["tmp_name", '$_FILES["fichero"]["tmp_name"];', "Ruta temporal donde se guarda."],
      ["move_uploaded_file()", 'move_uploaded_file($_FILES["f"]["tmp_name"], "upload/".$nombre);', "Mueve archivo del temporal al destino."],
      ["UPLOAD_ERR_OK", 'if ($_FILES["f"]["error"] == UPLOAD_ERR_OK)', "Subida correcta."],
      ["Validar extensión", 'pathinfo($nombre, PATHINFO_EXTENSION);', "Obtiene la extensión."],
      ["Validar tamaño", 'if ($_FILES["f"]["size"] > 8000000) { ... }', "Límite de tamaño."],
      ["Fichero temporal", '$_FILES["f"]["tmp_name"];', "Se elimina automáticamente al finalizar el script si no se mueve."],
      ["is_uploaded_file()", 'is_uploaded_file($_FILES["f"]["tmp_name"]);', "Comprueba si viene de formulario."],
      ["$_FILES completo", 'print_r($_FILES);', "Muestra nombre, tipo, tamaño, tmp_name, error."]
    ]
  },
  {
    titulo: "Formularios en PHP",
    contenido: [
      ["$_POST", '$_POST["nombre"];', "Recoge datos enviados por POST."],
      ["$_SERVER['REQUEST_METHOD']", 'if ($_SERVER["REQUEST_METHOD"] == "POST") {...}', "Comprueba si se envió el formulario."],
      ["htmlspecialchars()", 'htmlspecialchars($_POST["nombre"]);', "Evita XSS escapando caracteres."],
      ["trim()", 'trim($_POST["nombre"]);', "Elimina espacios."],
      ["filter_var()", 'filter_var($email, FILTER_VALIDATE_EMAIL);', "Valida email."],
      ["isset()", 'isset($_POST["campo"]);', "Comprueba si existe una clave."],
      ["empty()", 'empty($_POST["nombre"]);', "Comprueba si está vacío."],
      ["header()", 'header("Location: pagina.php");', "Redirige."],
      ["exit()", 'exit();', "Detiene la ejecución."]
    ]
  }
];
