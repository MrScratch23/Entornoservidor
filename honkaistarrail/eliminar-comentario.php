<?php
// eliminar-comentario.php - VERSIÓN PRODUCCIÓN
session_start();

// Configuración producción
ini_set('display_errors', 0);
error_reporting(0);

// Cargar archivos
require_once __DIR__ . '/includes/config.php';
require_once __DIR__ . '/includes/Database.php';

header('Content-Type: application/json; charset=utf-8');

// Función para respuestas
function jsonResponse($success, $data = []) {
    $response = ['success' => $success];
    
    if ($success) {
        $response = array_merge($response, $data);
    } else {
        $response['error'] = $data['error'] ?? 'Error desconocido';
        $response['type'] = $data['type'] ?? 'unknown_error';
    }
    
    echo json_encode($response, JSON_UNESCAPED_UNICODE);
    exit;
}

// ============================================
// VALIDACIONES
// ============================================

// Verificar sesión
if (!isset($_SESSION['usuario_id'])) {
    jsonResponse(false, [
        'error' => 'No autenticado',
        'type' => 'auth_error'
    ]);
}

$usuarioId = (int)$_SESSION['usuario_id'];

// Verificar método
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    jsonResponse(false, [
        'error' => 'Método no permitido',
        'type' => 'method_error'
    ]);
}

// Verificar datos
if (!isset($_POST['comentario_id'])) {
    jsonResponse(false, [
        'error' => 'ID de comentario requerido',
        'type' => 'validation_error'
    ]);
}

$comentarioId = (int)$_POST['comentario_id'];

// ============================================
// PROCESAR ELIMINACIÓN
// ============================================
try {
    $db = new Database();
    
    // Verificar que el comentario existe y pertenece al usuario
    $sqlVerificar = "SELECT cp.id_comentario, p.nombre as personaje_nombre 
                    FROM comentarios_personaje cp
                    JOIN personajes p ON cp.id_personaje = p.id_personaje
                    WHERE cp.id_comentario = ? AND cp.id_usuario = ?";
    
    $verificacion = $db->executeQuery($sqlVerificar, [$comentarioId, $usuarioId]);
    
    if (empty($verificacion)) {
        jsonResponse(false, [
            'error' => 'No tienes permiso para eliminar este comentario',
            'type' => 'permission_error'
        ]);
    }
    
    $personajeNombre = $verificacion[0]['personaje_nombre'];
    
    // Eliminar comentario
    $sqlEliminar = "DELETE FROM comentarios_personaje WHERE id_comentario = ?";
    $result = $db->executeUpdate($sqlEliminar, [$comentarioId]);
    
    if ($result === false) {
        throw new Exception('Error al eliminar el comentario');
    }
    
    // Respuesta de éxito
    jsonResponse(true, [
        'message' => 'Comentario eliminado correctamente',
        'type' => 'success',
        'comentario_eliminado' => [
            'id' => $comentarioId,
            'personaje_nombre' => $personajeNombre
        ],
        'timestamp' => date('Y-m-d H:i:s')
    ]);
    
} catch (Exception $e) {
    // Log del error
    error_log("ERROR eliminar-comentario - Usuario: $usuarioId, Comentario: $comentarioId - " . $e->getMessage());
    
    // Respuesta de error
    jsonResponse(false, [
        'error' => 'Error en el servidor. Por favor, intenta nuevamente.',
        'type' => 'server_error'
    ]);
}
?>