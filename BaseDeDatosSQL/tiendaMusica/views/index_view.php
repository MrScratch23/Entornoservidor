<?php


if (!isset($_SESSION['usuario'])) {
    header("Location: ../index.php", true, 302);
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tienda Virtual</title>
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
        }
        
        .container {
            max-width: 1200px;
            margin: 0 auto;
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 2px 15px rgba(0,0,0,0.08);
        }
        
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 2px solid #f0f0f0;
        }
        
        h1 {
            color: #333;
            margin: 0;
            font-size: 28px;
        }
        
        .user-info {
            display: flex;
            align-items: center;
            gap: 20px;
        }
        
        .welcome-message {
            font-weight: 600;
            color: #555;
        }
        
        .welcome-message span {
            color: #667eea;
            font-weight: 700;
        }
        
        .action-buttons {
            display: flex;
            gap: 10px;
            margin-bottom: 30px;
        }
        
        .btn {
            padding: 10px 20px;
            border-radius: 6px;
            text-decoration: none;
            font-weight: 600;
            font-size: 15px;
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
            display: inline-block;
            text-align: center;
        }
        
        .btn-add {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }
        
        .btn-logout {
            background: #6c757d;
            color: white;
        }
        
        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        }
        
        .message-container {
            margin-bottom: 25px;
        }
        
        .mensaje {
            padding: 15px 20px;
            border-radius: 8px;
            margin-bottom: 20px;
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
        
        table { 
            border-collapse: collapse; 
            width: 100%; 
            margin-top: 20px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.05);
            border-radius: 8px;
            overflow: hidden;
        }
        
        thead {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }
        
        th, td { 
            padding: 15px; 
            text-align: left; 
            border-bottom: 1px solid #eee;
        }
        
        th { 
            font-weight: 600;
            font-size: 14px;
        }
        
        tr:hover {
            background-color: #f9f9f9;
        }
        
        .actions {
            display: flex;
            gap: 8px;
        }
        
        .btn-action {
            padding: 6px 12px;
            border-radius: 4px;
            font-size: 13px;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.2s ease;
        }
        
        .btn-modificar {
            background-color: #ffc107;
            color: #212529;
        }
        
        .btn-eliminar {
            background-color: #dc3545;
            color: white;
        }
        
        .btn-action:hover {
            opacity: 0.9;
            transform: translateY(-1px);
        }
        
        .empty-state {
            text-align: center;
            padding: 50px 20px;
            color: #6c757d;
        }
        
        .empty-state h3 {
            margin-bottom: 10px;
            color: #495057;
        }
        
        @media (max-width: 768px) {
            .container {
                padding: 15px;
            }
            
            .header {
                flex-direction: column;
                gap: 15px;
                text-align: center;
            }
            
            .action-buttons {
                flex-direction: column;
            }
            
            .btn {
                width: 100%;
            }
            
            table {
                display: block;
                overflow-x: auto;
            }
            
            .actions {
                flex-direction: column;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Tienda de Música</h1>
            <div class="user-info">
                <div class="welcome-message">
                    Bienvenido, 
                    <span>
                        <?php 
                        if (isset($_SESSION['usuario'])) {
                            if (is_array($_SESSION['usuario'])) {
                                echo htmlspecialchars($_SESSION['usuario']['nombre'] ?? 'Usuario');
                            } else {
                                echo htmlspecialchars($_SESSION['usuario']);
                            }
                        } else {
                            echo 'Usuario';
                        }
                        ?>
                    </span>
                </div>
            </div>
        </div>
        
        <div class="action-buttons">
            <a href="views/agregar_producto_view.php" class="btn btn-add">
                + Agregar Nuevo Producto
            </a>
            <a href="controllers/cerrar_sesion.php" class="btn btn-logout">
                Cerrar Sesión
            </a>
        </div>
        
        <?php if (!empty($mensaje)): ?>
            <div class="message-container">
                <div class="mensaje <?php echo htmlspecialchars($tipo_mensaje); ?>">
                    <?php echo htmlspecialchars($mensaje); ?>
                </div>
            </div>
        <?php endif; ?>

        <h2>Listado de Productos</h2>
        
        <?php if (empty($lista_productos)): ?>
            <div class="empty-state">
                <h3>No hay productos en la tienda</h3>
                <p>¡Comienza agregando el primer producto!</p>
                <a href="views/agregar_producto_view.php" class="btn btn-add" style="margin-top: 15px; display: inline-block;">
                    + Agregar Primer Producto
                </a>
            </div>
        <?php else: ?>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Descripción</th>
                        <th>Precio</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($lista_productos as $prod): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($prod['id_producto']); ?></td>
                            <td><strong><?php echo htmlspecialchars($prod['nombre']); ?></strong></td>
                            <td><?php echo htmlspecialchars($prod['descripcion']); ?></td>
                            <td><strong><?php echo number_format($prod['precio'], 2); ?> €</strong></td>
                            <td>
                                <div class="actions">
                                    <a href="views/modificar_producto_view.php?id=<?php echo $prod['id_producto']; ?>" 
                                       class="btn-action btn-modificar">
                                        Modificar
                                    </a>
                                    <a href="controllers/eliminar_producto.php?id=<?php echo $prod['id_producto']; ?>" 
                                       class="btn-action btn-eliminar">
                                        Eliminar
                                    </a>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <p style="margin-top: 20px; color: #6c757d; font-size: 14px;">
                Mostrando <?php echo count($lista_productos); ?> producto(s)
            </p>
        <?php endif; ?>
    </div>
</body>
</html>