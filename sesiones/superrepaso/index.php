
<?php

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

$archivo = "usuarios.csv";
$_SESSION['todos_usuarios'] = cargarDatosSUPER($archivo, 'auto', ";");



?>



<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Sistema</title>
    <style>
        body { 
            font-family: Arial, sans-serif; 
            max-width: 500px; 
            margin: 50px auto; 
            padding: 20px;
            background: #f5f5f5;
        }
        .login-container {
            background: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .form-group { 
            margin-bottom: 20px; 
        }
        label { 
            display: block; 
            margin-bottom: 8px;
            font-weight: bold;
            color: #333;
        }
        input[type="email"], input[type="password"] { 
            width: 100%; 
            padding: 12px; 
            border: 1px solid #ddd; 
            border-radius: 4px;
            font-size: 16px;
            box-sizing: border-box;
        }
        button { 
            background: #007bff; 
            color: white; 
            padding: 12px 25px; 
            border: none; 
            border-radius: 4px; 
            cursor: pointer;
            font-size: 16px;
            width: 100%;
        }
        button:hover {
            background: #0056b3;
        }
        .error { 
            color: #d63031; 
            margin-bottom: 20px; 
            padding: 12px; 
            background: #ffeaea; 
            border: 1px solid #fab1a0;
            border-radius: 4px;
        }
        .success { 
            color: #00b894; 
            margin-bottom: 20px; 
            padding: 12px; 
            background: #eaffea; 
            border: 1px solid #55efc4;
            border-radius: 4px;
        }
        .checkbox-group {
            display: flex;
            align-items: center;
            gap: 8px;
            margin: 20px 0;
        }
        .users-demo {
            margin-top: 25px;
            padding: 15px;
            background: #f8f9fa;
            border-radius: 5px;
            border-left: 4px solid #007bff;
        }
        .users-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 10px;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h2 style="text-align: center; color: #333; margin-bottom: 30px;">🔐 Iniciar Sesión</h2>
        
        <!-- PHP: Aquí va la lógica de errores -->
        <div class="error" style="display: none;" id="error-message">
            <!-- Mensajes de error dinámicos -->
        </div>

        <div class="success" style="display: none;" id="success-message">
            <!-- Mensajes de éxito -->
        </div>

        <form action="procesar_login.php" method="POST">
            <div class="form-group">
                <label for="email">📧 Email:</label>
                <input type="email" id="email" name="email" required>
            </div>
            
            <div class="form-group">
                <label for="password">🔒 Contraseña:</label>
                <input type="password" id="password" name="password" required>
            </div>
            
            <div class="checkbox-group">
                <input type="checkbox" id="recordar" name="recordar">
                <label for="recordar" style="margin: 0;">💾 Recordar mi usuario</label>
            </div>
            
            <button type="submit">🚀 Ingresar al Sistema</button>
        </form>

        <div class="users-demo">
            <strong>👥 Usuarios de prueba:</strong>
            <?php foreach ($_SESSION['todos_usuarios'] as $usuario) :?>
            <div class="users-grid">
                <div><strong>Email: <?php echo $usuario['email'] ?></strong></div>
                <div><strong>Contraseña: <?php echo $usuario['password'] ?></strong></div>
                <div>Nombre: <?php echo $usuario['nombre']; ?></div>
                <div>Rol: <?php echo $usuario['rol'] ?></div>
            </div>
            <?php endforeach ?>
        </div>
    </div>
</body>
</html>