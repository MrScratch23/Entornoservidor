<!-- CONTENIDO PRINCIPAL-->
    <main class="main-content">
        <div class="container">
            <h1 class="title">Alta de Nueva Incidencia</h1>
            <section class="card">
                <!-- FORMULARIO DE ALTA-->
                <form action="index.php" method="POST">
                    <h2 class="table-title form-section-title">Detalles del incidencia</h2>
                    <!-- Campo asunto -->
                    <div class="form-group">
                        <label for="asunto">Asunto (incidencia)</label>
                        <input type="text" id="asunto" name="asunto" placeholder="Ej: Error PC01" value="">
                        <!-- Placeholder para mensaje de error -->
                        <span class="validation-error" id="error-asunto">Ejemplo de mensaje</span>
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
                        <span class="validation-error" id="error-tipo-incidencia">Ejemplo de mensaje</span>
                    </div>
                    <!-- Campo  Horas estimadas -->
                    <div class="form-row">
                        <div class="form-group form-col-50">
                            <label for="horas_estimadas">Horas estimadas</label>
                            <input type="number" id="horas_estimadas" name="horas_estimadas" placeholder="Ej: 2" value="">
                            <!-- Placeholder para mensaje de error -->
                            <span class="validation-error" id="error-horas">Ejemplo de mensaje</span>
                        </div>
                    </div>
                    <!-- Botones de Acción -->
                    <div class="form-actions">
                        <button type="submit" class="btn btn-save">
                            Guardar incidencia
                        </button>
                        <a href="#" class="btn btn-secondary btn-cancel">
                            Cancelar
                        </a>
                    </div>
                </form>
            </section>
            <!-- Mensaje para errores o éxito -->
            <div id="flash-message-container">
                <div class="flash-message error">Ejemplo de mensaje de error</div>
                <!-- <div class="flash-message success">Ejemplo de mensaje de éxito</div> -->
            </div>
        </div>
    </main>