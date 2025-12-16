<?php
// guardar-comentario.php - VERSIÓN PRODUCCIÓN
session_start();

// ============================================
// CONFIGURACIÓN DE ERRORES (PRODUCCIÓN)
// ============================================
ini_set('display_errors', 0);
ini_set('display_startup_errors', 0);
error_reporting(0);

// ============================================
// CARGAR ARCHIVOS NECESARIOS
// ============================================
require_once __DIR__ . '/includes/config.php';
require_once __DIR__ . '/includes/Database.php';
require_once __DIR__ . '/models/ComentarioPersonajeModel.php';

// ============================================
// HEADER JSON
// ============================================
header('Content-Type: application/json; charset=utf-8');

// ============================================
// FUNCIÓN PARA RESPUESTAS JSON
// ============================================
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
// 1. VERIFICAR SESIÓN (USUARIO REAL)
// ============================================
if (!isset($_SESSION['usuario_id'])) {
    jsonResponse(false, [
        'error' => 'Debes iniciar sesión para comentar',
        'type' => 'auth_error'
    ]);
}

$usuarioId = (int)$_SESSION['usuario_id'];

// ============================================
// 2. VERIFICAR MÉTODO
// ============================================
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    jsonResponse(false, [
        'error' => 'Método no permitido. Usa POST.',
        'type' => 'method_error'
    ]);
}

// ============================================
// 3. VERIFICAR DATOS
// ============================================
if (!isset($_POST['personaje_id']) || !isset($_POST['contenido'])) {
    jsonResponse(false, [
        'error' => 'Datos incompletos',
        'type' => 'validation_error'
    ]);
}

$personajeId = (int)$_POST['personaje_id'];
$contenido = trim($_POST['contenido']);

if (empty($contenido)) {
    jsonResponse(false, [
        'error' => 'El comentario no puede estar vacío',
        'type' => 'validation_error'
    ]);
}

if (strlen($contenido) > 500) {
    jsonResponse(false, [
        'error' => 'El comentario no puede tener más de 500 caracteres',
        'type' => 'validation_error'
    ]);
}

// ============================================
// 4. PROCESAMIENTO PRINCIPAL
// ============================================
try {
    // Inicializar conexión
    $db = new Database();
    
    // ============================================
    // VERIFICAR USUARIO AUTENTICADO
    // ============================================
    $sqlUsuario = "SELECT id_usuario, username, nombre FROM usuarios WHERE id_usuario = ?";
    $usuarioData = $db->executeQuery($sqlUsuario, [$usuarioId]);
    
    if (empty($usuarioData)) {
        // Usuario en sesión pero no existe en BD - sesión corrupta
        session_destroy();
        jsonResponse(false, [
            'error' => 'Sesión inválida. Por favor, inicia sesión nuevamente.',
            'type' => 'session_error'
        ]);
    }
    
    $username = $usuarioData[0]['username'];
    $nombreUsuario = $usuarioData[0]['nombre'] ?? $username;
    
    // ============================================
    // VERIFICAR PERSONAJE
    // ============================================
    $sqlPersonaje = "SELECT id_personaje, nombre FROM personajes WHERE id_personaje = ?";
    $personajeData = $db->executeQuery($sqlPersonaje, [$personajeId]);
    
    if (empty($personajeData)) {
        jsonResponse(false, [
            'error' => 'Personaje no encontrado',
            'type' => 'validation_error'
        ]);
    }
    
    $personajeNombre = $personajeData[0]['nombre'];
    
    // ============================================
    // INSERTAR COMENTARIO
    // ============================================
    $sqlInsert = "INSERT INTO comentarios_personaje (id_usuario, id_personaje, contenido) VALUES (?, ?, ?)";
    $contenidoSanitizado = htmlspecialchars($contenido, ENT_QUOTES, 'UTF-8');
    
    $result = $db->executeUpdate($sqlInsert, [$usuarioId, $personajeId, $contenidoSanitizado]);
    
    if ($result === false) {
        throw new Exception('Error al guardar el comentario');
    }
    
    // ============================================
    // OBTENER DATOS DEL COMENTARIO INSERTADO
    // ============================================
    $sqlLastId = "SELECT LAST_INSERT_ID() as last_id";
    $lastIdData = $db->executeQuery($sqlLastId);
    $comentarioId = $lastIdData[0]['last_id'] ?? 0;
    
    // Obtener comentario completo
    $comentarioCompleto = null;
    if ($comentarioId > 0) {
        $sqlComentario = "SELECT cp.*, u.username, u.nombre as usuario_nombre 
                         FROM comentarios_personaje cp 
                         JOIN usuarios u ON cp.id_usuario = u.id_usuario 
                         WHERE cp.id_comentario = ?";
        $comentarioData = $db->executeQuery($sqlComentario, [$comentarioId]);
        $comentarioCompleto = !empty($comentarioData) ? $comentarioData[0] : null;
    }
    
    // Contar total de comentarios
    $sqlCount = "SELECT COUNT(*) as total FROM comentarios_personaje WHERE id_personaje = ?";
    $countData = $db->executeQuery($sqlCount, [$personajeId]);
    $totalComentarios = $countData[0]['total'] ?? 0;
    
    // ============================================
    // RESPUESTA DE ÉXITO
    // ============================================
    jsonResponse(true, [
        'message' => 'Comentario publicado correctamente',
        'type' => 'success',
        'comentario' => $comentarioCompleto,
        'total_comentarios' => $totalComentarios,
        'personaje_nombre' => $personajeNombre,
        'timestamp' => date('Y-m-d H:i:s')
    ]);
    
} catch (Exception $e) {
    // Log del error (solo en archivo)
    error_log("ERROR guardar-comentario - Usuario: $usuarioId, Personaje: $personajeId - " . $e->getMessage());
    
    // Respuesta de error genérica (sin detalles en producción)
    jsonResponse(false, [
        'error' => 'Error en el servidor. Por favor, intenta nuevamente.',
        'type' => 'server_error'
    ]);
}
?>