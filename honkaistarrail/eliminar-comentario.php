<?php
// eliminar-comentario.php
session_start();

$base_dir = dirname(__DIR__);
require_once $base_dir . '/includes/config.php';
require_once $base_dir . '/includes/Database.php';

header('Content-Type: application/json');

if (!isset($_SESSION['usuario_id'])) {
    echo json_encode(['error' => 'No autenticado']);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['error' => 'Método no permitido']);
    exit;
}

if (!isset($_POST['comentario_id'])) {
    echo json_encode(['error' => 'ID de comentario requerido']);
    exit;
}

$comentarioId = (int)$_POST['comentario_id'];
$usuarioId = $_SESSION['usuario_id'];

try {
    $db = new Database();
    
    // Verificar que el comentario pertenece al usuario
    $sql = "SELECT id_comentario FROM comentarios_personaje WHERE id_comentario = ? AND id_usuario = ?";
    $resultado = $db->executeQuery($sql, [$comentarioId, $usuarioId]);
    
    if (empty($resultado)) {
        echo json_encode(['error' => 'No tienes permiso para eliminar este comentario']);
        exit;
    }
    
    // Eliminar comentario
    $sql = "DELETE FROM comentarios_personaje WHERE id_comentario = ?";
    $result = $db->executeUpdate($sql, [$comentarioId]);
    
    if ($result !== false) {
        echo json_encode(['success' => true, 'message' => 'Comentario eliminado']);
    } else {
        echo json_encode(['error' => 'Error al eliminar comentario: ' . $db->error]);
    }
    
} catch (Exception $e) {
    echo json_encode(['error' => 'Error al eliminar comentario: ' . $e->getMessage()]);
}
?>