<!-- 
    Plantilla HTML+CSS para el Examen PHP - 2DAW
    Profesor: P.Lluyot
    Fecha: Diciembre 2025
    IES Cristóbal de Monroy
-->

<?php 
session_start();
require_once "TicketModel.php";
$model = new TicketModel();

if (!isset($_SESSION['usuario'])) {
    header("Location: login.php", true, 302);
    exit();
}

$errores = [];
$mensajeError = '';


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // validaciones
    $asunto = $_POST['asunto'] ?? '';
    $tipo_incidencia = $_POST['tipo_incidencia'] ?? '';
    $horas_estimadas = $_POST['horas_estimadas'] ?? '';

    if ($asunto === '') {
        $errores['asunto'] = "El campo no puede estar vacio.";
    }
    if ($tipo_incidencia === '') {
        $errores['tipo_incidencia'] = "Escoja un tipo incidencia.";
    }

    if (!is_numeric($horas_estimadas)) {
        $errores['horas_estimadas'] = "Error de numero.";
    }
    if ($horas_estimadas === '') {
        $errores['horas_estimadas'] = "Introduzca un numero.";
    }
    if ($horas_estimadas < 1) {
        $errores['horas_estimadas'] = "El numero de horas debe ser positivo";
    }


    if (empty($errores)) {
        $resultado = $model->crear($asunto, $tipo_incidencia, $horas_estimadas);

        if ($resultado) {
            $_SESSION['mensajeExito'] = "Registro completado correctamente";
            header("Location: index.php", true, 302);
            exit();
        } else {
            $mensajeError = "Hubo un error creando el ticket.";
            header("Location: alta.php", true, 302);
            exit();
        }

    } else {
        $mensajeError = "Los campos no fueron rellenados correctamente";
    }



// no me dio tiempo a hacer lo del sticky para el formulario, perdona pepe, aunque ya tengo una idea mas o menos para la base

    
}

?>


<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Incidencias - Examen PHP</title>
    <link rel="stylesheet" href="css/estilos.css">
</head>

<body>

    <!-- CABECERA (Menú superior estático) -->
    <header class="header">
        <div class="container header-content">
            <div class="logo">
                <span class="logo-icon">⚙️</span> Gestión de Incidencias
            </div>

            <nav class="nav-menu">
                <a href="index.php">📋 Dashboard</a>
                <a href="logout.php" class="salir">🚪 Salir</a>
            </nav>
        </div>
    </header>

    <!-- CONTENIDO PRINCIPAL-->
    <main class="main-content">
        <div class="container">
            <h1 class="title">Alta de Nueva Incidencia</h1>
            <section class="card">
                <!-- FORMULARIO DE ALTA-->
                <form action="alta.php" method="POST">
                    <h2 class="table-title form-section-title">Detalles del incidencia</h2>
                    <!-- Campo asunto -->
                    <div class="form-group">
                        <label for="asunto">Asunto (incidencia)</label>
                        <input type="text" id="asunto" name="asunto" placeholder="Ej: Error PC01" value="">
                        <!-- Placeholder para mensaje de error -->
                         <?php if (isset($errores['asunto'])): ?>
                            <span class="validation-error" id="error-asunto"><?php echo $errores['asunto']; ?></span>
                         <?php endif; ?>               
                    </div>
                    <!-- Campo Tipo de incidencia -->
                    <div class="form-group">
                        <label for="tipo_incidencia">Tipo de Incidencia</label>
                        <select id="tipo_incidencia" name="tipo_incidencia">
                            <option value="">-- Seleccione un tipo --</option>
                            <option value="Hardware">Hardware</option>
                            <option value="Software">Software</option>
                            <option value="Red">Red</option>
                            <option value="Otros">Otros</option>
                        </select>
                        <!-- Placeholder para mensaje de error -->
                          <?php if (isset($errores['tipo_incidencia'])): ?>
                            <span class="validation-error" id="error-tipo-incidencia"><?php echo $errores['tipo_incidencia']; ?></span>
                         <?php endif; ?>   
                    </div>
                    <!-- Campo  Horas estimadas -->
                    <div class="form-row">
                        <div class="form-group form-col-50">
                            <label for="horas_estimadas">Horas estimadas</label>
                            <input type="number" id="horas_estimadas" name="horas_estimadas" placeholder="Ej: 2" value="">
                            <!-- Placeholder para mensaje de error -->
                             <?php if (isset($errores['horas_estimadas'])): ?>
                                 <span class="validation-error" id="error-horas"><?php echo $errores['horas_estimadas']; ?></span>
                             <?php endif; ?>
                        </div>
                    </div>
                    <!-- Botones de Acción -->
                    <div class="form-actions">
                        <button type="submit" class="btn btn-save">
                            Guardar incidencia
                        </button>
                        <a href="index.php" class="btn btn-secondary btn-cancel">
                            Cancelar
                        </a>
                    </div>
                </form>
            </section>
            <!-- Mensaje para errores o éxito -->
            <div id="flash-message-container">
                <?php if (!empty($mensajeError)) : ?>
                <div class="flash-message error"><?php echo $mensajeError ?></div>
                <!-- <div class="flash-message success">Ejemplo de mensaje de éxito</div> -->
                 <?php endif; ?>
            </div>
        </div>
    </main>

    <!-- PIE DE PÁGINA -->
    <footer class="footer">
        <div class="container">
            <p>
                © 2025 IES Cristóbal de Monroy. Examen PHP.
            </p>
        </div>
    </footer>



</body>

</html>