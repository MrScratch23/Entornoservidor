<?php
// la sesion ya esta iniciada, no haria falta
// session_start();

if (!isset($_SESSION['usuario'])) {
    header("Location: login.php", true, 302);
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
    
       body { font-family: sans-serif; padding: 20px; }
       table { border-collapse: collapse; width: 100%; margin-top: 20px;}
       th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
       th { background-color: #f2f2f2; }
       .mensaje { padding: 10px; margin-bottom: 20px; border-radius: 5px; }
       .exito { background-color: #d4edda; color: #155724; }
       .error { background-color: #f8d7da; color: #721c24; }
       .btn { padding: 5px 10px; margin: 2px; border: none; border-radius: 3px; cursor: pointer; text-decoration: none; display: inline-block; }
       .btn-eliminar { background-color: #dc3545; color: white; }
       .btn-modificar { background-color: #ffc107; color: black; }
       .btn-agregar { background-color: #28a745; color: white; padding: 10px 15px; text-decoration: none; border-radius: 5px; display: inline-block; margin-bottom: 20px; }
       .btn-salir { background-color: #6c757d; color: white; padding: 10px 15px; text-decoration: none; border-radius: 5px; display: inline-block; margin-left: 10px; }
   </style>
</head>
<body>
   <h1>Gestión de Productos</h1>
   
   <div style="margin-bottom: 20px;">
       <a href="controllers/agregar_producto.php" class="btn-agregar">
           + Agregar Nuevo Producto
       </a>
       <a href="controllers/cerrar_sesion.php" class="btn-salir">
           Cerrar Sesión
       </a>
   </div>
   
   <?php if (!empty($mensaje)): ?>
       <div class="mensaje <?php echo htmlspecialchars($tipo_mensaje); ?>">
           <?php echo htmlspecialchars($mensaje); ?>
       </div>
   <?php endif; ?>

   <h2>Listado de Productos</h2>
   
   <?php if (empty($lista_productos)): ?>
       <p>No hay productos en la tienda. ¡Agrega el primero!</p>
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
                       <td><?php echo htmlspecialchars($prod['nombre']); ?></td>
                       <td><?php echo htmlspecialchars($prod['descripcion']); ?></td>
                       <td><?php echo number_format($prod['precio'], 2); ?> €</td>
                       <td>
                         
                           <a href="controllers/modificar_producto.php?id=<?php echo $prod['id_producto']; ?>" 
                              class="btn btn-modificar">
                              Modificar
                           </a>
                           
                          
                           <a href="controllers/eliminar_producto.php?id=<?php echo $prod['id_producto']; ?>" 
                              class="btn btn-eliminar">
                              Eliminar
                           </a>
                       </td>
                   </tr>
               <?php endforeach; ?>
           </tbody>
       </table>
   <?php endif; ?>
</body>
</html>