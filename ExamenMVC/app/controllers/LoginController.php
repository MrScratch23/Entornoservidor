<?php
namespace RubenMolinaExamenMVC\App\controllers;

use RubenMolinaExamenMVC\App\models\LoginModel;
use RubenMolinaExamenMVC\Lib\SessionManager;

class LoginController extends Controller {
    
    public static function mostrarFormularioLogin() {
        SessionManager::iniciarSesion();
        
        // redigir
        if (isset($_SESSION['usuario'])) {
            header("Location: " . BASE_URL);
            exit();
        }
        
        $errores = [];
        $mensaje = '';
        $mensajeError = '';
    
        // mensajes flash
        if (isset($_SESSION['mensaje_exito'])) {
            $mensaje = $_SESSION['mensaje_exito'];
            unset($_SESSION['mensaje_exito']);
        }
        
        
        if (isset($_SESSION['mensaje-error'])) {
            $mensajeError = $_SESSION['mensaje-error'];
            unset($_SESSION['mensaje-error']);
        }
        
        self::mostrarVista('login_view', [
            'errores' => $errores, 
            'mensaje' => $mensaje,
            'mensajeError' => $mensajeError
        ]);
    }
    

    public static function autenticarUsuario() {
        SessionManager::iniciarSesion();
        
        $credencial = htmlspecialchars(trim($_POST['credencial']) ?? '');
        $errores = [];

        if ($credencial === '') {
            $errores['usuario'] = "El usuario no puede estar vacío";
        }

        $pinSeparado = explode("-", $credencial);

        // tiene dos partes? por si acaso
        if (count($pinSeparado) !== 2) {
            $errores['usuario'] = "Formato incorrecto. Use: CODIGO-PIN";
        } elseif (empty($pinSeparado[0]) || empty($pinSeparado[1])) {
            $errores['usuario'] = "Error en las credenciales de usuario";
        }
     
        if (!empty($errores)) {
            self::mostrarVista('login_view', ['errores' => $errores]);
            return;
        }

        $model = new LoginModel();
        $usuario = trim($pinSeparado[0]);
        $pin = trim($pinSeparado[1]);
        $usuarioAutenticado = $model->autentificarUsuario($usuario, $pin);
        
        if ($usuarioAutenticado) {
            $_SESSION['usuario'] = $usuarioAutenticado;
            header('Location: ' . BASE_URL);
            exit;
        } else {
            $_SESSION['mensaje-error'] = "Usuario o contraseña incorrectos";
            header('Location: ' . BASE_URL . 'login');
            exit;
        }
    }

    public static function cerrarSesion() {
       

        SessionManager::destruirSesion();
        SessionManager::iniciarSesion();
        SessionManager::crearMensajeFlash("mensaje_exito", "Sesion cerrada correctamente");
         header('Location: ' . BASE_URL . 'login');
        exit();

       
    }
}
?>