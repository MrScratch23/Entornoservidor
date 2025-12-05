

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Agregar Nuevo Producto</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        body { 
            background-color: #f5f5f5;
            padding: 20px;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        
        .container {
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 2px 15px rgba(0,0,0,0.08);
            width: 100%;
            max-width: 600px;
            padding: 30px;
        }
        
        h1 {
            color: #333;
            margin-bottom: 25px;
            padding-bottom: 15px;
            border-bottom: 2px solid #f0f0f0;
            text-align: center;
        }
        
        .form-group { 
            margin-bottom: 20px; 
        }
        
        label { 
            display: block; 
            margin-bottom: 8px; 
            font-weight: 600;
            color: #555;
        }
        
        input, textarea { 
            width: 100%; 
            padding: 12px; 
            border: 2px solid #e1e1e1; 
            border-radius: 6px; 
            box-sizing: border-box;
            font-size: 16px;
            transition: all 0.3s ease;
        }
        
        input:focus, textarea:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }
        
        textarea {
            min-height: 120px;
            resize: vertical;
        }
        
        .button-group {
            display: flex;
            gap: 10px;
            margin-top: 30px;
        }
        
        .btn { 
            padding: 12px 20px; 
            border: none; 
            border-radius: 6px; 
            cursor: pointer; 
            text-decoration: none; 
            display: inline-block;
            font-weight: 600;
            font-size: 15px;
            transition: all 0.3s ease;
            text-align: center;
        }
        
        .btn-guardar { 
            background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
            color: white; 
            flex: 2;
        }
        
        .btn-cancelar { 
            background: #6c757d; 
            color: white; 
            flex: 1;
        }
        
        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        }
        
        .mensaje { 
            padding: 15px 20px; 
            margin-bottom: 25px; 
            border-radius: 8px;
            font-weight: 500;
            animation: fadeIn 0.3s ease;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .exito { 
            background-color: #d4edda; 
            color: #155724;
            border-left: 4px solid #28a745;
        }
        
        .error { 
            background-color: #f8d7da; 
            color: #721c24;
            border-left: 4px solid #dc3545;
        }
        
        .error-message {
            color: #dc3545;
            font-size: 14px;
            margin-top: 5px;
            display: block;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>➕ Agregar Nuevo Producto</h1>
        
        <?php if (isset($mensaje) && !empty($mensaje)): ?>
            <div class="mensaje <?php echo htmlspecialchars($tipo_mensaje ?? ''); ?>">
                <?php echo htmlspecialchars($mensaje); ?>
            </div>
        <?php endif; ?>

        <form method="POST" action="../controllers/agregar_producto.php">
            <div class="form-group">
                <label for="nombre">Nombre del Producto *</label>
                <input type="text" 
                       id="nombre" 
                       name="nombre" 
                       value="<?php echo htmlspecialchars($_POST['nombre'] ?? ''); ?>"
                       placeholder="Ingrese el nombre del producto">
                <?php if (isset($errores['nombre'])): ?>
                <span class="error-message"><?php echo htmlspecialchars($errores['nombre']); ?></span>
                <?php endif; ?>
            </div>
            
            <div class="form-group">
                <label for="descripcion">Descripción</label>
                <textarea id="descripcion" 
                          name="descripcion" 
                          rows="4"
                          placeholder="Ingrese una descripción del producto"><?php echo htmlspecialchars($_POST['descripcion'] ?? ''); ?></textarea>
            </div>
            
            <div class="form-group">
                <label for="precio">Precio (€) *</label>
                <input type="number" 
                       id="precio" 
                       name="precio" 
                       step="0.01" 
                       min="0"
                       value="<?php echo htmlspecialchars($_POST['precio'] ?? ''); ?>"
                       placeholder="0.00">
                <?php if (isset($errores['precio'])): ?>
                <span class="error-message"><?php echo htmlspecialchars($errores['precio']); ?></span>
                <?php endif; ?>
            </div>
            
            <div class="button-group">
                <a href="../index.php" class="btn btn-cancelar">↩️ Cancelar</a>
                <button type="submit" class="btn btn-guardar">➕ Crear Producto</button>
            </div>
        </form>
    </div>
</body>
</html>