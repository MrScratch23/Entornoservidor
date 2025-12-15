<?php
// guardar-comentario.php
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

if (!isset($_POST['personaje_id']) || !isset($_POST['contenido'])) {
    echo json_encode(['error' => 'Datos incompletos']);
    exit;
}

$personajeId = (int)$_POST['personaje_id'];
$contenido = trim($_POST['contenido']);
$usuarioId = $_SESSION['usuario_id'];

if (empty($contenido)) {
    echo json_encode(['error' => 'El contenido no puede estar vacío']);
    exit;
}

if (strlen($contenido) > 500) {
    echo json_encode(['error' => 'El comentario no puede tener más de 500 caracteres']);
    exit;
}

try {
    $db = new Database();
    
    // Insertar comentario
    $sql = "INSERT INTO comentarios_personaje (id_usuario, id_personaje, contenido) VALUES (?, ?, ?)";
    $result = $db->executeUpdate($sql, [$usuarioId, $personajeId, $contenido]);
    
    if ($result !== false) {
        echo json_encode(['success' => true, 'message' => 'Comentario guardado']);
    } else {
        echo json_encode(['error' => 'Error al guardar comentario: ' . $db->error]);
    }
    
} catch (Exception $e) {
    echo json_encode(['error' => 'Error al guardar comentario: ' . $e->getMessage()]);
}
?>