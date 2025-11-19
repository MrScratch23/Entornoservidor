<?php
// ========================================================================================
// ACTIVIDAD PRÁCTICA: SISTEMA DE RESERVA DE CINE (CINE DWES)
// diseñada por P.Lluyot-2025
// ========================================================================================

// ----------------------------------------------------------------------------------------
// Definición de constantes y variables
// ----------------------------------------------------------------------------------------
$filas = 6;
$asientos = 5;

// Inicializa aquí las variables que necesitarás a lo largo del script
$cine = [];
$reservas = [];
$mensaje = '';
$tipoMensaje = '';
$nombre = '';

// ----------------------------------------------------------------------------------------
// Definición de funciones
// ----------------------------------------------------------------------------------------

function cargarDatosSUPER($archivo, $formato = 'indexado', $delimitador = ',')
{
    $datos = [];
    if (!file_exists($archivo)) return $datos;
    
    $manejador = @fopen($archivo, "r");
    if ($manejador) {
        // Leer primera línea con el delimitador personalizado
        $primeraLinea = fgetcsv($manejador, 0, $delimitador);
        if ($primeraLinea === false) {
            fclose($manejador);
            return $datos;
        }
        
        // Verificar si la primera línea parece encabezados (no numérica)
        $tieneEncabezados = false;
        if ($formato === 'auto') {
            $tieneEncabezados = !is_numeric(trim($primeraLinea[0]));
        }
        
        // Si tiene encabezados, procesar de forma asociativa
        if ($tieneEncabezados) {
            $encabezados = $primeraLinea;
            while (!feof($manejador)) {
                $temp = fgetcsv($manejador, 0, $delimitador);
                if ($temp === false || (count($temp) === 1 && empty(trim($temp[0])))) continue;
                
                $fila = [];
                foreach ($encabezados as $index => $encabezado) {
                    $fila[trim($encabezado)] = $temp[$index] ?? '';
                }
                $datos[] = $fila;
            }
        } else {
            // Si no tiene encabezados, procesar como indexado
            $datos[] = $primeraLinea; // Guardar la primera línea también
            while (!feof($manejador)) {
                $temp = fgetcsv($manejador, 0, $delimitador);
                if ($temp === false || (count($temp) === 1 && empty(trim($temp[0])))) continue;
                $datos[] = $temp;
            }
        }
        
        fclose($manejador);
    }
    return $datos;
}

function guardarReserva($archivo, $fila, $asiento, $nombre)
{
    $manejador = fopen($archivo, "a");
    if ($manejador) {
        fputcsv($manejador, [$fila, $asiento, $nombre, date('Y-m-d H:i:s')]);
        fclose($manejador);
        return true;
    }
    return false;
}

function vaciarSala($archivo)
{
    $manejador = fopen($archivo, "w");
    if ($manejador) {
        fputcsv($manejador, ['fila', 'asiento', 'nombre', 'fecha_reserva']);
        fclose($manejador);
        return true;
    }
    return false;
}

// ----------------------------------------------------------------------------------------
// LÓGICA PRINCIPAL DE LA APLICACIÓN
// ----------------------------------------------------------------------------------------

// 1. Inicialización: Matriz de estado bidimensional de la sala
for ($fila = 0; $fila < $filas; $fila++) {
    for ($asiento = 0; $asiento < $asientos; $asiento++) {
        $cine[$fila][$asiento] = 0; // 0 = libre, 1 = ocupado
    }
}

// 2. Carga de Persistencia: Carga las reservas existentes
$archivo = "reservas.csv";
$reservas = cargarDatosSUPER($archivo, 'auto');

// Marcar asientos ocupados en la matriz
foreach ($reservas as $reserva) {
    if (isset($reserva['fila']) && isset($reserva['asiento'])) {
        $fila = intval($reserva['fila']);
        $asiento = intval($reserva['asiento']);
        if (isset($cine[$fila][$asiento])) {
            $cine[$fila][$asiento] = 1;
        }
    }
}

// 3. Procesa los datos del formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['vaciar'])) {
        // Vaciar sala
        if (vaciarSala($archivo)) {
            // Reinicializar matriz
            for ($fila = 0; $fila < $filas; $fila++) {
                for ($asiento = 0; $asiento < $asientos; $asiento++) {
                    $cine[$fila][$asiento] = 0;
                }
            }
            $mensaje = "Sala vaciada correctamente";
            $tipoMensaje = "exito";
            $reservas = [];
        } else {
            $mensaje = "Error al vaciar la sala";
            $tipoMensaje = "error";
        }
    } elseif (isset($_POST['asiento'])) {
        // Procesar reserva
        $nombre = trim($_POST['nombre'] ?? '');
        $asientoSeleccionado = $_POST['asiento'];
        
        // Validaciones
        if (empty($nombre)) {
            $mensaje = "Debe introducir su nombre";
            $tipoMensaje = "error";
        } else {
            list($fila, $asiento) = explode('-', $asientoSeleccionado);
            $fila = intval($fila);
            $asiento = intval($asiento);
            
            if ($cine[$fila][$asiento] === 1) {
                $mensaje = "El asiento seleccionado ya está ocupado";
                $tipoMensaje = "error";
            } else {
                // Guardar reserva
                if (guardarReserva($archivo, $fila, $asiento, $nombre)) {
                    $cine[$fila][$asiento] = 1;
                    $mensaje = "Reserva realizada con éxito para $nombre en Fila " . ($fila + 1) . " Asiento " . ($asiento + 1);
                    $tipoMensaje = "exito";
                    $nombre = ''; // Limpiar campo nombre
                } else {
                    $mensaje = "Error al guardar la reserva";
                    $tipoMensaje = "error";
                }
            }
        }
    }
}

// 4. Calcula las estadísticas finales
$totalAsientos = $filas * $asientos;
$asientosOcupados = 0;

foreach ($cine as $fila) {
    foreach ($fila as $estado) {
        if ($estado === 1) {
            $asientosOcupados++;
        }
    }
}

$asientosDisponibles = $totalAsientos - $asientosOcupados;
$porcentajeOcupacion = $totalAsientos > 0 ? round(($asientosOcupados / $totalAsientos) * 100, 2) : 0;

// Generar tabla de asientos
$mensajeTabla = '<table class="tabla-asientos"><thead><tr><th></th>';
for ($i = 0; $i < $asientos; $i++) {
    $mensajeTabla .= '<th>A' . ($i + 1) . '</th>';
}
$mensajeTabla .= '</tr></thead><tbody>';

for ($fila = 0; $fila < $filas; $fila++) {
    $mensajeTabla .= '<tr><th>Fila ' . ($fila + 1) . '</th>';
    for ($asiento = 0; $asiento < $asientos; $asiento++) {
        if ($cine[$fila][$asiento] === 1) {
            // Asiento ocupado
            $mensajeTabla .= '<td><span class="asiento ocupado" title="Asiento Ocupado">';
            $mensajeTabla .= '<img src="img/sillon_ocupado.svg" alt="asiento ocupado">';
            $mensajeTabla .= '</span></td>';
        } else {
            // Asiento libre
            $mensajeTabla .= '<td><button type="submit" name="asiento" value="' . $fila . '-' . $asiento . '" ';
            $mensajeTabla .= 'class="asiento libre" title="Asiento Libre">';
            $mensajeTabla .= '<img src="img/sillon_libre.svg" alt="asiento libre">';
            $mensajeTabla .= '</button></td>';
        }
    }
    $mensajeTabla .= '</tr>';
}
$mensajeTabla .= '</tbody></table>';

?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cine DWES - Reservas</title>
    <link rel="stylesheet" href="https://cdn.simplecss.org/simple.min.css">
    <link rel="stylesheet" href="css/cine.css">
</head>

<body>
    <header>
        <h1>🎬 Cine DWES</h1>
        <p>Sistema de Reservas - <?php echo "Filas: $filas - Asientos: $asientos"; ?></p>
    </header>
    
    <main>
        <h3>Reserva de asientos</h3>

        <!-- Mensajes de error o éxito -->
        <?php if ($mensaje): ?>
            <p class="notice <?php echo $tipoMensaje; ?>"><?php echo $mensaje; ?></p>
        <?php endif; ?>

        <form method="POST" class="form-reserva">
            <label for="nombre">Tu Nombre:</label>
            <input type="text" id="nombre" name="nombre" size="35" 
                   placeholder="Introduce tu nombre completo" 
                   value="<?php echo htmlspecialchars($nombre); ?>">
            
            <div class="pantalla">PANTALLA</div>

            <div class="sala">
                <?php echo $mensajeTabla; ?>
            </div>
        </form>
        
        <p class="info">Introduce tu nombre y selecciona un asiento libre.</p>

        <!-- Estadísticas -->
        <section class="estadisticas">
            <h3>Estadísticas de la Sala</h3>
            <ul>
                <li>Asientos Ocupados: <strong><?php echo $asientosOcupados; ?></strong></li>
                <li>Asientos Disponibles: <strong><?php echo $asientosDisponibles; ?></strong></li>
                <li>Porcentaje de Ocupación: <strong><?php echo $porcentajeOcupacion; ?>%</strong></li>
            </ul>
        </section>

        <!-- Administración -->
        <section class="administracion">
            <h4>Administración</h4>
            <form method="POST">
                <button type="submit" name="vaciar" value="1" class="btn-peligro" 
                        onclick="return confirm('¿Está seguro de que desea vaciar toda la sala?')">
                    Vaciar Sala
                </button>
            </form>
        </section>
    </main>
    
    <footer>
        <p>Desarrollo Web en Entorno Servidor - Examen Práctico - P.Lluyot</p>
    </footer>
</body>
</html>