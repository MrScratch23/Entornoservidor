<!DOCTYPE html>
<html lang="es">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Tienda Virtual</title>
   <style> <!-- puedes incluirlo en un fichero estilos.css externo —->
       body { font-family: sans-serif; padding: 20px; }
       table { border-collapse: collapse; width: 100%; margin-top: 20px;}
       th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
       th { background-color: #f2f2f2; }
       .mensaje { padding: 10px; margin-bottom: 20px; border-radius: 5px; }
       .exito { background-color: #d4edda; color: #155724; }
       .error { background-color: #f8d7da; color: #721c24; }
   </style>
</head>
<body>
   <h1>Gestión de Productos</h1>
   <?php if (isset($mensaje)): ?>
       <div class="mensaje <?php echo $tipo_mensaje; ?>">
           <?php echo $mensaje; ?>
       </div>
   <?php endif; ?>
   <h2>Listado de Productos</h2>
   <table>
       <thead>
           <tr>
               <th>ID</th>
               <th>Nombre</th>
               <th>Descripción</th>
               <th>Precio</th>
           </tr>
       </thead>
       <tbody>
           <?php foreach ($lista_productos as $prod): ?>
               <tr>
                   <td><?php echo $prod['id_producto']; ?></td>
                   <td><?php echo $prod['nombre']; ?></td>
                   <td><?php echo $prod['descripcion']; ?></td>
                   <td><?php echo number_format($prod['precio'], 2); ?> €</td>
               </tr>
           <?php endforeach; ?>
       </tbody>
   </table>


</body>
</html>
