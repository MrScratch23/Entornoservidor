<?php


use RubenMolinaExamen\Lib\Route;

use RubenMolinaExamen\App\controllers\HomeController;
use RubenMolinaExamen\App\controllers\IncidenciaController;
use RubenMolinaExamen\App\controllers\LoginController;


Route::get('/', [LoginController::class, 'mostrarFormularioLogin'] );
Route::get('/login', [LoginController::class, 'mostrarFormularioLogin']);


Route::post('/login', [LoginController::class, 'autenticarUsuario']);
Route::get('/logout', [LoginController::class, 'cerrarSesion']);

Route::get('/principal', [HomeController::class, 'index']);
Route::get('/alta', [IncidenciaController::class, 'mostrarFormularioAlta']);
Route::post('/alta', [IncidenciaController::class, 'validarFormulario']);
Route::get('/eliminar/{id}', [IncidenciaController::class, 'borrarEntrada']);
Route::get('/actualizar/{id}', [IncidenciaController::class, 'actualizarEstado']);
Route::get('/modificar/{id}', [IncidenciaController::class, 'mostrarFormularioModificar']);
Route::post('modificar/{id}', [IncidenciaController::class, 'modificarTicket']);



// practicas
/*
// En route.php:
Route::get('/perfil/{usuario_id}', [UsuarioController::class, 'verPerfil']);

// En UsuarioController.php:
public static function verPerfil($usuario_id) {
    SessionManager::iniciarSesion();
    
    // 1. Validar que el usuario está logueado
    if (!isset($_SESSION['usuario'])) {
        header("Location: " . BASE_URL . "login");
        exit;
    }
    
    // 2. Validar que $usuario_id es un número válido
    if (empty($usuario_id) || !ctype_digit($usuario_id)) {
        $_SESSION['mensajeError'] = "ID de usuario inválida";
        header("Location: " . BASE_URL . "principal");
        exit();
    }
    
    // 3. Convertir a entero
    $id = intval($usuario_id);
    
    // 4. Obtener datos del usuario
    $model = new UsuarioModel();
    $usuario = $model->obtenerUsuario($id);
    
    // 5. Verificar que el usuario existe
    if (empty($usuario)) {
        $_SESSION['mensajeError'] = "Usuario no encontrado";
        header("Location: " . BASE_URL . "principal");
        exit();
    }
    
    // 6. (Opcional) Validar permisos
    $usuarioActual = $_SESSION['usuario']; // Asumo que guardas datos del usuario logueado
    $esAdmin = ($usuarioActual['rol'] ?? '') === 'admin';
    $esSuPropioPerfil = ($usuarioActual['id'] ?? 0) == $id;
    
    if (!$esAdmin && !$esSuPropioPerfil) {
        $_SESSION['mensajeError'] = "No tienes permiso para ver este perfil";
        header("Location: " . BASE_URL . "principal");
        exit();
    }
    
    // 7. Mostrar vista
    self::mostrarVista('perfil_view', [
        'usuario' => $usuario[0] // Primer elemento del array
    ]);
}

*/



Route::handleRoute();
?>