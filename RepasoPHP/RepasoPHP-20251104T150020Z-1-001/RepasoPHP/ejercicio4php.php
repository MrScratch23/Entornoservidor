<?php
// =============================================
// TU CÓDIGO PHP AQUÍ - EJERCICIO 4
// =============================================

$mensaje = "";
$texto = "Texto de ejemplo personalizable";
$estilos = "";
$tamano_input = "";
$color_input = "";
$estilo_input = "";

// 1. PROCESAR FORMULARIO CON MÉTODO POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // 2. OBTENER DATOS DEL FORMULARIO
   
$tamano_input = $_POST['tamano'] ?? '';
$color_input = ($_POST['color']) ?? '';
$estilo_input = ($_POST['estilo']) ?? '';




// 3. APLICAR ESTILOS SEGÚN LAS OPCIONES

// 4. CONSTRUIR EL CSS PARA LOS ESTILOS

switch ($tamano_input) {
    case 'pequeno':
        $estilos .= "font-size: 12px; ";
        break;
        case 'mediano':
         $estilos .= "font-size: 16px; ";
         break;
            case 'grande':
                $estilos .= "font-size: 24px; ";
                break;
    default:
        break;
}

switch ($color_input) {
    case 'rojo':
        $estilos .= "color: red; ";
        break;
    case 'azul':
        $estilos .= "color: blue; ";
        break;
        case 'verde':
            $estilos .= "color: green; ";
         break;
        case 'negro':
            $estilos .= "color: black; ";
         break;    
    
    default:
        # code...
        break;
}

switch ($estilo_input) {
    case 'normal':
        $estilos .= "font-style: normal; font-weight: normal; ";
        break;
        case 'negrita':
            $estilos .= "font-weight: bold; ";
            break;
        case 'cursiva':    
            $estilos .= "font-style: italic; ";
            break;
    
    default:
       
        break;
}




// 5. MOSTRAR EL TEXTO CON ESTILOS APLICADOS

$mensaje = "El tamaño del texto ahora es: $tamano_input <br>
El color del texto ahora es: $color_input <br>
El estilo del texto ahora es: $estilo_input
";



}
// =============================================
// FIN DE TU CÓDIGO PHP
// =============================================
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Personalizador de Texto</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 40px; }
        .container { max-width: 600px; margin: 0 auto; }
        .form-group { margin: 15px 0; }
        label { display: block; margin-bottom: 5px; font-weight: bold; }
        select { padding: 10px; width: 200px; border: 2px solid #ddd; border-radius: 5px; }
        button { padding: 10px 20px; background: #007bff; color: white; border: none; border-radius: 5px; cursor: pointer; }
        button:hover { background: #0056b3; }
        .texto-ejemplo { margin: 20px 0; padding: 20px; border: 1px solid #ccc; border-radius: 8px; }
    </style>
</head>
<body>
    <div class="container">
        <h1>Personalizador de Texto</h1>
        
        <form method="POST">
            <div class="form-group">
                <label for="tamano">Tamaño de texto:</label>
                <select id="tamano" name="tamano">
                    <option value="pequeno">Pequeño</option>
                    <option value="mediano">Mediano</option>
                    <option value="grande">Grande</option>
                </select>
            </div>
            
            <div class="form-group">
                <label for="color">Color de texto:</label>
                <select id="color" name="color">
                    <option value="rojo">Rojo</option>
                    <option value="azul">Azul</option>
                    <option value="verde">Verde</option>
                    <option value="negro">Negro</option>
                </select>
            </div>
            
            <div class="form-group">
                <label for="estilo">Estilo:</label>
                <select id="estilo" name="estilo">
                    <option value="normal">Normal</option>
                    <option value="negrita">Negrita</option>
                    <option value="cursiva">Cursiva</option>
                </select>
            </div>
            
            <button type="submit">Aplicar Estilos</button>
        </form>
        
        <div class="texto-ejemplo" style="<?php echo $estilos; ?>">
            <h2>Texto de Ejemplo:</h2>
            <?php echo $texto; ?>
        </div>
        
        <div class="resultado">
            <?php echo $mensaje; ?>
        </div>
    </div>
</body>
</html>