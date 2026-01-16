<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modificar Incidencia - Gestión de Incidencias</title>
    <style>
        /* RESET Y ESTILOS GENERALES */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f5f7fa;
            color: #333;
            line-height: 1.6;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .container {
            width: 90%;
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }

        /* HEADER */
        .header {
            background: linear-gradient(135deg, #2c3e50 0%, #4a6491 100%);
            color: white;
            padding: 1rem 0;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        .header-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo {
            font-size: 1.5rem;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .logo-icon {
            font-size: 1.8rem;
        }

        /* NAVEGACIÓN */
        .nav-menu {
            display: flex;
            gap: 25px;
            align-items: center;
        }

        .nav-menu a {
            color: white;
            text-decoration: none;
            font-weight: 500;
            padding: 8px 15px;
            border-radius: 6px;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .nav-menu a:hover {
            background-color: rgba(255, 255, 255, 0.15);
            transform: translateY(-2px);
        }

        .nav-menu a.salir {
            background-color: rgba(220, 53, 69, 0.2);
            border: 1px solid rgba(220, 53, 69, 0.3);
        }

        .nav-menu a.salir:hover {
            background-color: rgba(220, 53, 69, 0.3);
        }

        /* CONTENIDO PRINCIPAL */
        .main-content {
            flex: 1;
            padding: 2rem 0;
        }

        .title {
            color: #2c3e50;
            margin-bottom: 2rem;
            font-size: 2rem;
            text-align: center;
            position: relative;
            padding-bottom: 10px;
        }

        .title::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 100px;
            height: 4px;
            background: linear-gradient(90deg, #3498db, #2c3e50);
            border-radius: 2px;
        }

        /* CARD */
        .card {
            background: white;
            border-radius: 12px;
            padding: 2rem;
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.08);
            margin-bottom: 2rem;
            border: 1px solid #e1e5eb;
        }

        /* FORMULARIO */
        .form-section-title {
            color: #2c3e50;
            margin-bottom: 1.5rem;
            font-size: 1.3rem;
            border-bottom: 2px solid #eaeaea;
            padding-bottom: 10px;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #2c3e50;
        }

        .form-group input,
        .form-group select {
            width: 100%;
            padding: 12px 15px;
            border: 2px solid #dce1e6;
            border-radius: 8px;
            font-size: 1rem;
            transition: all 0.3s ease;
            background-color: white;
        }

        .form-group input:focus,
        .form-group select:focus {
            outline: none;
            border-color: #3498db;
            box-shadow: 0 0 0 3px rgba(52, 152, 219, 0.2);
        }

        .form-group input:hover,
        .form-group select:hover {
            border-color: #a0aec0;
        }

        .form-row {
            display: flex;
            gap: 20px;
            flex-wrap: wrap;
        }

        .form-col-50 {
            flex: 1;
            min-width: 250px;
        }

        /* VALIDACIÓN */
        .validation-error {
            display: block;
            color: #e74c3c;
            font-size: 0.875rem;
            margin-top: 5px;
            padding: 5px 10px;
            background-color: rgba(231, 76, 60, 0.08);
            border-radius: 4px;
            border-left: 3px solid #e74c3c;
        }

        /* BOTONES */
        .form-actions {
            display: flex;
            gap: 15px;
            margin-top: 2rem;
            padding-top: 1.5rem;
            border-top: 1px solid #eaeaea;
            flex-wrap: wrap;
        }

        .btn {
            padding: 12px 30px;
            border: none;
            border-radius: 8px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 140px;
        }

        .btn-save {
            background: linear-gradient(135deg, #3498db 0%, #2980b9 100%);
            color: white;
        }

        .btn-save:hover {
            background: linear-gradient(135deg, #2980b9 0%, #1c5d87 100%);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(52, 152, 219, 0.3);
        }

        .btn-secondary {
            background: #f8f9fa;
            color: #495057;
            border: 2px solid #dee2e6;
        }

        .btn-secondary:hover {
            background: #e9ecef;
            transform: translateY(-2px);
            border-color: #adb5bd;
        }

        .btn-cancel {
            background: #f8f9fa;
            color: #495057;
            border: 2px solid #dee2e6;
        }

        .btn-cancel:hover {
            background: #e9ecef;
            transform: translateY(-2px);
            border-color: #adb5bd;
        }

        /* MENSAJES FLASH */
        #flash-message-container {
            margin-top: 1.5rem;
        }

        .flash-message {
            padding: 15px 20px;
            border-radius: 8px;
            margin-bottom: 1rem;
            font-weight: 500;
            animation: slideIn 0.3s ease;
        }

        .flash-message.error {
            background-color: rgba(231, 76, 60, 0.1);
            color: #c0392b;
            border-left: 4px solid #e74c3c;
        }

        .flash-message.success {
            background-color: rgba(46, 204, 113, 0.1);
            color: #27ae60;
            border-left: 4px solid #2ecc71;
        }

        /* ANIMACIONES */
        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* RESPONSIVE */
        @media (max-width: 768px) {
            .header-content {
                flex-direction: column;
                gap: 15px;
            }

            .nav-menu {
                width: 100%;
                justify-content: center;
            }

            .title {
                font-size: 1.6rem;
            }

            .card {
                padding: 1.5rem;
            }

            .form-actions {
                flex-direction: column;
            }

            .btn {
                width: 100%;
            }

            .form-col-50 {
                min-width: 100%;
            }
        }

        @media (max-width: 480px) {
            .container {
                width: 95%;
                padding: 0 10px;
            }

            .logo {
                font-size: 1.3rem;
            }

            .nav-menu {
                flex-direction: column;
                gap: 10px;
            }

            .nav-menu a {
                width: 100%;
                justify-content: center;
            }

            .card {
                padding: 1rem;
            }

            .title {
                font-size: 1.4rem;
            }
        }

        /* ESTILOS ESPECÍFICOS PARA SELECT */
        select {
            appearance: none;
            background-image: url("data:image/svg+xml;charset=UTF-8,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='%232c3e50' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3e%3cpolyline points='6 9 12 15 18 9'%3e%3c/polyline%3e%3c/svg%3e");
            background-repeat: no-repeat;
            background-position: right 15px center;
            background-size: 16px;
            padding-right: 45px;
        }

        /* PLACEHOLDER ESTILIZADO */
        ::placeholder {
            color: #a0aec0;
            opacity: 0.8;
        }

       
        input[type="number"]::-webkit-outer-spin-button,
        input[type="number"]::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }
    </style>
</head>
<body>
    <!-- CABECERA (Menú superior estático) -->
    <header class="header">
        <div class="container header-content">
            <div class="logo">
                <span class="logo-icon">⚙️</span> Gestión de Incidencias
            </div>

            <nav class="nav-menu">
                <a href="<?php echo BASE_URL; ?>principal">📋 Dashboard</a>
                <a href="<?php echo BASE_URL; ?>logout" class="salir">🚪 Salir</a>
            </nav>
        </div>
    </header>

    <!-- CONTENIDO PRINCIPAL -->
    <main class="main-content">
        <div class="container">
            <h1 class="title">Modificar Incidencia</h1>
            
            <section class="card">
                <!-- FORMULARIO DE MODIFICACIÓN -->
                <form action="<?php echo BASE_URL; ?>modificar/<?php echo htmlspecialchars($datos['id'] ?? ''); ?>" method="POST">
                    <h2 class="table-title form-section-title">Detalles de la incidencia</h2>
                    
                    <!-- Campo ID oculto -->
                    <input type="hidden" id="id" name="id" value="<?php echo htmlspecialchars($datos['id'] ?? ''); ?>">
                    
                    <!-- Campo asunto -->
                    <div class="form-group">
                        <label for="asunto">Asunto (incidencia)</label>
                        <input type="text" id="asunto" name="asunto" 
                               placeholder="Ej: Error PC01" 
                               value="<?php echo htmlspecialchars($datos['asunto'] ?? ''); ?>">
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
                        <?php if (isset($errores['tipo_incidencia'])): ?>
                            <span class="validation-error" id="error-tipo-incidencia">
                                <?php echo $errores['tipo_incidencia']; ?>
                            </span>
                        <?php endif; ?>
                    </div>
                    
                    <!-- Campo Estado -->
                    <div class="form-group">
                        <label for="estado">Estado</label>
                        <select id="estado" name="estado">
                            <option value="">-- Seleccione estado --</option>
                            <?php 
                            $estados = ["Pendiente", "En curso", "Resuelta"];
                            $estadoSeleccionado = $datos['estado'] ?? '';
                            foreach ($estados as $estado): 
                                $selected = ($estadoSeleccionado === $estado) ? 'selected' : '';
                            ?>
                                <option value="<?php echo $estado; ?>" <?php echo $selected; ?>>
                                    <?php echo $estado; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <?php if (isset($errores['estado'])): ?>
                            <span class="validation-error" id="error-estado">
                                <?php echo $errores['estado']; ?>
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
                            Guardar cambios
                        </button>
                        <a href="<?php echo BASE_URL; ?>principal" class="btn btn-secondary btn-cancel">
                            Cancelar
                        </a>
                    </div>
                </form>
            </section>
            
            <!-- Mensaje para errores o éxito -->
            <div id="flash-message-container">
                <?php if (isset($_SESSION['mensajeError']) && $_SESSION['mensajeError']): ?>
                    <div class="flash-message error"><?php echo $_SESSION['mensajeError']; ?></div>
                    <?php unset($_SESSION['mensajeError']); ?>
                <?php endif; ?>
                <?php if (isset($_SESSION['mensajeExito']) && $_SESSION['mensajeExito']): ?>
                    <div class="flash-message success"><?php echo $_SESSION['mensajeExito']; ?></div>
                    <?php unset($_SESSION['mensajeExito']); ?>
                <?php endif; ?>
            </div>
        </div>
    </main>
</body>
</html>