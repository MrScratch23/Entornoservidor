<?php
// detalles-personaje-data.php
session_start();

// Ruta absoluta a la raíz del proyecto
$base_dir = __DIR__;  // __DIR__ ya es la carpeta actual

// Configurar rutas absolutas
require_once $base_dir . '/includes/config.php';
require_once $base_dir . '/includes/Database.php';
require_once $base_dir . '/models/DetallePersonajeModel.php';

// IMPORTANTE: Configurar headers ANTES de cualquier output
header('Content-Type: application/json');
header('Cache-Control: no-cache, no-store, must-revalidate');

// Silenciar errores que puedan interrumpir el JSON
ini_set('display_errors', 0);
error_reporting(E_ALL);

// Buffer de salida para capturar errores
ob_start();

try {
    if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
        throw new Exception('ID de personaje inválido');
    }
    
    $personajeId = (int)$_GET['id'];
    
    // Verificar que los archivos existen
    if (!file_exists($base_dir . '/includes/Database.php')) {
        throw new Exception('Archivo Database.php no encontrado');
    }
    
    if (!file_exists($base_dir . '/models/DetallePersonajeModel.php')) {
        throw new Exception('Archivo DetallePersonajeModel.php no encontrado');
    }
    
    // Crear instancia del modelo
    $detalleModel = new DetallePersonajeModel();
    
    // Obtener datos básicos del personaje
    $db = new Database();
    $sql = "SELECT * FROM personajes WHERE id_personaje = ?";
    $resultado = $db->executeQuery($sql, [$personajeId]);
    
    if (empty($resultado)) {
        throw new Exception('Personaje no encontrado');
    }
    
    $personaje = $resultado[0];
    
    // Obtener todos los detalles usando el modelo
    $detalles = $detalleModel->obtenerDetallesCompletos($personajeId);
    
    // Obtener comentarios con información de usuario
    $sql = "SELECT cp.*, u.username, u.nombre as usuario_nombre 
            FROM comentarios_personaje cp 
            JOIN usuarios u ON cp.id_usuario = u.id_usuario 
            WHERE cp.id_personaje = ? 
            ORDER BY cp.fecha_creacion DESC";
    $comentarios = $db->executeQuery($sql, [$personajeId]);
    
    // Marcar si el comentario es del usuario actual
    $usuarioId = $_SESSION['usuario_id'] ?? null;
    foreach ($comentarios as &$comentario) {
        $comentario['es_propietario'] = ($comentario['id_usuario'] == $usuarioId);
    }
    
    // Preparar respuesta exitosa
    $response = [
        'success' => true,
        'personaje' => $personaje,
        'detalles' => $detalles,
        'comentarios' => $comentarios
    ];
    
} catch (Exception $e) {
    // Limpiar buffer de errores
    ob_clean();
    
    $response = [
        'success' => false,
        'error' => $e->getMessage(),
        'trace' => $e->getTraceAsString()
    ];
}

// Limpiar cualquier output no deseado
$output = ob_get_clean();

// Si hay output no deseado, agregarlo al error
if (!empty($output) && !isset($response['success'])) {
    $response = [
        'success' => false,
        'error' => 'Output no esperado del servidor',
        'output' => $output
    ];
}

// Enviar respuesta JSON
echo json_encode($response, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
exit();
?>