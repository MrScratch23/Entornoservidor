<?php
require_once __DIR__ . '/layout/header.php';
?>

<!-- CONTENIDO PRINCIPAL-->
<main class="main-content">
    <div class="container">
        <h1 class="title">Alta de Nueva Incidencia</h1>
        <section class="card">
            <!-- FORMULARIO DE ALTA-->
            <form action="alta" method="POST">
                <h2 class="table-title form-section-title">Detalles del incidencia</h2>
                
                <!-- Campo asunto -->
                <div class="form-group">
                    <label for="asunto">Asunto (incidencia)</label>
                    <input type="text" id="asunto" name="asunto" 
                           placeholder="Ej: Error PC01" 
                           value="<?php echo htmlspecialchars($datos['asunto'] ?? ''); ?>">
                    <!-- Placeholder para mensaje de error -->
                    <?php if (isset($errores['asunto'])): ?>
                        <span class="validation-error" id="error-asunto">
                            <?php echo $errores['asunto']; ?>
                        </span>
                    <?php endif; ?>               
                </div>
                
                <!-- Campo Tipo de incidencia -->
                <div class="form-group">
                    <label for="tipo_incidencia">Tipo de Incidencia</label>
                    <select id="tipo_incidencia" name="tipo_incidencia">
                        <option value="">-- Seleccione un tipo --</option>
                        <?php 
                        $tipos = ["Hardware", "Software", "Red", "Otros"];
                        $tipoSeleccionado = $datos['tipo_incidencia'] ?? '';
                        foreach ($tipos as $tipo): 
                            $selected = ($tipoSeleccionado === $tipo) ? 'selected' : '';
                        ?>
                            <option value="<?php echo $tipo; ?>" <?php echo $selected; ?>>
                                <?php echo $tipo; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <!-- Placeholder para mensaje de error -->
                    <?php if (isset($errores['tipo_incidencia'])): ?>
                        <span class="validation-error" id="error-tipo-incidencia">
                            <?php echo $errores['tipo_incidencia']; ?>
                        </span>
                    <?php endif; ?>   
                </div>
                
                <!-- Campo Horas estimadas -->
                <div class="form-row">
                    <div class="form-group form-col-50">
                        <label for="horas_estimadas">Horas estimadas</label>
                        <input type="number" id="horas_estimadas" name="horas_estimadas" 
                               placeholder="Ej: 2" 
                               value="<?php echo htmlspecialchars($datos['horas_estimadas'] ?? ''); ?>">
                        <!-- Placeholder para mensaje de error -->
                        <?php if (isset($errores['horas_estimadas'])): ?>
                            <span class="validation-error" id="error-horas">
                                <?php echo $errores['horas_estimadas']; ?>
                            </span>
                        <?php endif; ?>
                    </div>
                </div>
                
                <!-- Botones de Acción -->
                <div class="form-actions">
                    <button type="submit" class="btn btn-save">
                        Guardar incidencia
                    </button>
                    <a href="principal" class="btn btn-secondary btn-cancel">
                        Cancelar
                    </a>
                </div>
            </form>
        </section>
        
        <!-- Mensaje para errores o éxito -->
        <div id="flash-message-container">
            <?php if (!empty($mensajeError)) : ?>
                <div class="flash-message error"><?php echo $mensajeError ?></div>
            <?php endif; ?>
            <?php if (!empty($mensajeExito)) : ?>
                <div class="flash-message success"><?php echo $mensajeExito ?></div>
            <?php endif; ?>
        </div>
    </div>
</main>

<?php
require_once __DIR__ . '/layout/footer.php';
?>