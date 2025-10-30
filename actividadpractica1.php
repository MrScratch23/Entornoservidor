<?php
$numero_mesas = 0;
$reservas = array();


// añado algunos datos de prueba

$reservas = array(
    array("nombreCliente" => "Pepe",   "numPersonas" => 4, "exterior" => true,  "horaReserva" => "21:00"),
    array("nombreCliente" => "Ana",    "numPersonas" => 3, "exterior" => false, "horaReserva" => "22:00"),
    array("nombreCliente" => "Paco",   "numPersonas" => 5, "exterior" => false, "horaReserva" => "21:30"),
    array("nombreCliente" => "Manuel", "numPersonas" => 2, "exterior" => false, "horaReserva" => "21:00"),
    array("nombreCliente" => "Rosa",   "numPersonas" => 6, "exterior" => false, "horaReserva" => "22:00"),
    array("nombreCliente" => "Pedro",  "numPersonas" => 5, "exterior" => false, "horaReserva" => "20:00"),
);

// cuento el numero  número de mesas
$numero_mesas = count($reservas);

// parametros get
if (isset($_GET['accion'])) {
    // uso un switch en este caso
    switch ($_GET['accion']) {
        case 'reservar':
            if (isset($_GET['nombre']) && isset($_GET['personas'])) {
                $exterior = isset($_GET['exterior']) && $_GET['exterior'] === 'true';
                $hora = isset($_GET['hora']) ? $_GET['hora'] : '20:00';
                realizarReserva($_GET['nombre'], $_GET['personas'], $exterior, $hora);
            }
            break;
            
        case 'cancelar':
            if (isset($_GET['nombre'])) {
                cancelarReserva($_GET['nombre']);
            }
            break;
            
        case 'mostrar':
            // solo mostrar reservas
            break;
    }
}

function realizarReserva($nombreCliente, $numPersonas, $exterior = false, $horaReserva = '20:00') {
    // debo declarlas globales para poder modificarlas, no se si preferias otra manera
    global $reservas, $numero_mesas;
    
    $errores = "";


    if ($numero_mesas >= 10) {
        $errores = "El restaurante está lleno.";
    }
    // verificar si el cliente ya esta dentro
    else {
        foreach ($reservas as $reserva) {
            if ($reserva['nombreCliente'] === $nombreCliente) {
                $errores = "El cliente con ese nombre ya tiene una reserva.";
                break;
            }
        }
    }

    
    if ($numPersonas > 6 || $numPersonas < 1) {
        $errores .= "El número de personas es incorrecto (debe ser entre 1 y 6). ";
    }

    
    if ($numPersonas > 4 && $numero_mesas > 8) {
        $errores .= "No quedan suficientes mesas disponibles para grupos grandes. ";
    }

    // solo agregar la reserva si no hay errores
    if (empty($errores)) {
        $nuevaReserva = array(
            "nombreCliente" => $nombreCliente,
            "numPersonas" => $numPersonas,
            "exterior" => $exterior,
            "horaReserva" => $horaReserva
        );
        
        $reservas[] = $nuevaReserva;
        $numero_mesas++;
        echo "<div class='exito'>Reserva realizada con éxito para $nombreCliente!</div>";
        return true;
    } else {
        echo "<div class='error'>Errores: $errores</div>";
        return false;
    }
}

function cancelarReserva($nombreCliente) {
    global $reservas, $numero_mesas;
    
    $reservaEncontrada = false;
    $nuevasReservas = array();
    
    // buscar y eliminar la reserva con un bucle
    foreach ($reservas as $reserva) {
        if ($reserva['nombreCliente'] === $nombreCliente) {
            $reservaEncontrada = true;
            $numero_mesas--;
        } else {
            $nuevasReservas[] = $reserva;
        }
    }
    
    $reservas = $nuevasReservas;
    
    if ($reservaEncontrada) {
        echo "<div class='exito'>Reserva cancelada para $nombreCliente</div>";
        return true;
    } else {
        echo "<div class='error'>No se encontró reserva para $nombreCliente</div>";
        return false;
    }
}

function mostrarReservas() {
    global $reservas, $numero_mesas;
    
    echo "<section class='reservas-section'>";
    echo "<h2>Listado de reservas</h2>";
    
    // tabla de reservas hechas a lo bruto
    echo "<table class='tabla-reservas'>";
    echo "<thead>";
    echo "<tr>";
    echo "<th>Nº</th>";
    echo "<th>NOMBRE</th>";
    echo "<th>PERSONAS</th>";
    echo "<th>UBICACIÓN</th>";
    echo "<th>HORA</th>";
    echo "</tr>";
    echo "</thead>";
    echo "<tbody>";
    
    if (empty($reservas)) {
        echo "<tr><td colspan='5' style='text-align: center;'>No hay reservas realizadas</td></tr>";
    } else {
        $contador = 1;
        foreach ($reservas as $reserva) {
            echo "<tr>";
            echo "<td>" . $contador . "</td>";
            echo "<td>" . htmlspecialchars($reserva['nombreCliente']) . "</td>";
            echo "<td>" . $reserva['numPersonas'] . "</td>";
            echo "<td>" . ($reserva['exterior'] ? 'Exterior' : 'Interior') . "</td>";
            echo "<td>" . $reserva['horaReserva'] . "</td>";
            echo "</tr>";
            $contador++;
        }
    }
    
    echo "</tbody>";
    echo "</table>";
    
    // contador de mesas
    echo "<div class='contador-mesas'>";
    echo "(" . $numero_mesas . "/10) mesas reservadas";
    echo "</div>";
    
    echo "</section>";
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de Reservas - Restaurante</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: Arial, sans-serif;
            background: #f5f5f5;
            padding: 20px;
        }
        
        .container {
            max-width: 1000px;
            margin: 0 auto;
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            overflow: hidden;
        }
        
        header {
            background: #2c3e50;
            color: white;
            padding: 25px;
            text-align: center;
        }
        
        header h1 {
            font-size: 24px;
            font-weight: normal;
        }
        
        .ejemplos-uso {
            background: #ecf0f1;
            padding: 20px;
            border-bottom: 1px solid #bdc3c7;
        }
        
        .ejemplos-uso h3 {
            margin-bottom: 15px;
            color: #2c3e50;
        }
        
        .ejemplos-uso a {
            display: block;
            margin: 5px 0;
            color: #2980b9;
            text-decoration: none;
            font-family: monospace;
            font-size: 14px;
        }
        
        .ejemplos-uso a:hover {
            text-decoration: underline;
        }
        
        .reservas-section {
            padding: 0;
        }
        
        .reservas-section h2 {
            background: #34495e;
            color: white;
            padding: 15px 25px;
            font-size: 18px;
            font-weight: normal;
            margin: 0;
        }
        
        .tabla-reservas {
            width: 100%;
            border-collapse: collapse;
            font-size: 14px;
        }
        
        .tabla-reservas th {
            background: #ecf0f1;
            color: #2c3e50;
            padding: 12px 15px;
            text-align: left;
            font-weight: normal;
            border-bottom: 2px solid #bdc3c7;
        }
        
        .tabla-reservas td {
            padding: 12px 15px;
            border-bottom: 1px solid #ecf0f1;
            color: #2c3e50;
        }
        
        .tabla-reservas tr:last-child td {
            border-bottom: none;
        }
        
        .contador-mesas {
            background: #e74c3c;
            color: white;
            padding: 15px 25px;
            text-align: center;
            font-size: 14px;
            margin-top: 0;
        }
        
        .exito {
            background: #d4edda;
            color: #155724;
            padding: 15px 25px;
            border: 1px solid #c3e6cb;
            margin: 0;
        }
        
        .error {
            background: #f8d7da;
            color: #721c24;
            padding: 15px 25px;
            border: 1px solid #f5c6cb;
            margin: 0;
        }
        
        footer {
            background: #34495e;
            color: white;
            padding: 20px;
            text-align: center;
            font-size: 12px;
        }
    </style>
</head>
<body>
    <div class="container">
        <header>
            <h1>Sistema de Reservas del Restaurante</h1>
        </header>

        <section class="ejemplos-uso">
            <h3>Ejemplos de Uso:</h3>
            <a href="?accion=reservar&nombre=Juan&personas=4&exterior=true&hora=21:00">
                ?accion=reservar&nombre=Juan&personas=4&exterior=true&hora=21:00
            </a>
            <a href="?accion=cancelar&nombre=Juan">
                ?accion=cancelar&nombre=Juan
            </a>
            <a href="?accion=mostrar">
                ?accion=mostrar
            </a>
        </section>

        <main>
      
            <?php mostrarReservas(); ?>
        </main>

        <footer>
            <p>Sistema de Reservas - Práctica 1</p>
        </footer>
    </div>
</body>
</html>
