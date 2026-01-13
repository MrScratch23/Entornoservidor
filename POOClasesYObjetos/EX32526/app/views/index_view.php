<?php


//$modelo = new IncidenciaModel();

// $tickets = $modelo->obtenerTodos();

require_once __DIR__ . '/layout/header.php';




?>
<!-- CONTENIDO PRINCIPAL-->
    <main class="main-content">
        <div class="container">
            <h1 class="title">Panel de Incidencias</h1>
            <!-- TARJETAS DE ESTADÍSTICAS-->
            <section class="stats-grid">
                <div class="card stat-card total">
                    <span class="stat-icon">📝</span>
                    <div>
                        <p class="stat-label">Total Tickets</p>
                        <p class="stat-value"><?php echo count($tickets) ?></p>
                    </div>
                </div>
                <div class="card stat-card average">
                    <span class="stat-icon">⏱️</span>
                    <div>
                        <p class="stat-label">Media de Horas</p>
                        <?php if ($mediaHoras === 0): ?>
                            <p class="stat-value">No hay horas registradas</p>
                            <?php endif ?>

                        <p class="stat-value"><?php echo number_format($mediaHoras, 2, "."); ?></p>
                    </div>
                </div>
            </section>
            <!-- MENSAJES FLASH -->
            <div id="flash-message-container">
                <?php if (!empty($_SESSION['mensajeExito']) || (!empty($_SESSION['mensajeError']))) : ?>
                <div class="flash-message success">
                        <?php
                        if (!empty($_SESSION['mensajeExito'])) {
                            echo $_SESSION['mensajeExito'];
                        unset($_SESSION['mensajeExito']);
                        }
                           if (!empty($_SESSION['mensajeError'])) {
                            echo $_SESSION['mensajeError'];
                        unset($_SESSION['mensajeError']);
                        }
                        
                        ?>
                </div>
                <?php endif; ?>
                <?php if (count($tickets) === 0):?>
                <div class="flash-message error">No hay incidencias registradas actualmente</div> 
                 <?php endif; ?>
            </div>
            <!-- TABLA DE INCIDENCIAS (CRUD) -->
            <section class="card">
                <div class="table-controls">
                    <h2 class="table-title">Listado de Incidencias</h2>
                    <!-- Enlace para ir al formulario de alta -->
                    <a href="alta.php" class="btn btn-add">
                        ➕ Nueva Incidencia
                    </a>
                </div>
        
                <div class="table-wrapper">
                    <!-- tabla que contiene las incidencias -->
                    <table class="crud-table">
                        <thead>
                            <tr>
                                <th>Estado</th>
                                <th>Tipo</th>
                                <th>Asunto</th>
                                <th>Horas</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- iteramos por cada incidencia -->
                                     <?php foreach ($tickets as $ticket) :?>
                            <tr>
                                <td>
                                    <!-- estado pendiente -->
                                     <?php if ($ticket['estado'] === "Pendiente") :?>
                                    <span class="status-pendiente">
                                      <?php echo $ticket['estado'] ?> </span>
                                      <?php endif; ?>
                                    <?php if ($ticket['estado'] === "En curso"): ?>    
                                        <span class="status-encurso">
                                            <?php echo $ticket['estado'] ?> </span>
                                     <?php endif; ?>
                                       <?php if ($ticket['estado'] === "Resuelta"): ?>    
                                        <span class="status-resuelta">
                                            <?php echo $ticket['estado'] ?> </span>
                                     <?php endif; ?>      
                                        
                                </td>
                                <td><?php echo $ticket['tipo_incidencia'] ?></td>
                                <td style="font-weight: 600;">
                                    <?php echo $ticket['asunto'] ?></td>
                                <td style="font-weight: 700; color: var(--color-primary);">
                                    <?php echo $ticket['horas_estimadas'] ?> h
                                </td>
                                <td>
                                    <!-- acciones (CRUD) -->
                                    <div class="table-actions">
                                        <!--enlace que actualiza el estado del viaje-->
                                        <a href="actualizar.php?id=<?php echo $ticket['id']; ?>" class="btn-toggle-status" title="Cambiar Estado">🔄</a>
                                        <!--enlace que elimina el viaje-->

                                        <a href="eliminar.php?id=<?php echo $ticket['id']; ?>" class="btn-delete" title="Eliminar">🗑️</a>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                               <?php endforeach ?> 
                        </tbody>
                    </table>
                    
                </div>
                
            </section>
        </div>
    </main>

<?php
require_once __DIR__ . '/layout/footer.php';
?>