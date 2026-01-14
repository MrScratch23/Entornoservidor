<?php
namespace RubenMolinaExamen\App\controllers;

use RubenMolinaExamen\App\models\LoginModel;

class LoginController extends Controller {
    
    
    public static function mostrarFormularioLogin() {
     
        $errores = [];
        $mensaje = '';
    

        // recuperar tambien el mensaje de exito
        if (isset($_SESSION['mensaje_exito'])) {
            $mensaje = $_SESSION['mensaje_exito'];
            unset($_SESSION['mensaje_exito']);
        }
        self::mostrarVista('login_view', ['errores' => $errores, 'mensaje' => $mensaje]);
    }
    

    public static function autenticarUsuario() {
       
        
        $usuarioInput = $_POST['usuario'] ?? '';
        $passwordInput = $_POST['password'] ?? '';
        
        $errores = [];

        
        if (empty($usuarioInput)) {
            $errores['usuario'] = "El usuario no puede estar vacío";
        }

        if (empty($passwordInput)) {
            $errores['password'] = "La contraseña no puede estar vacía";
        }

     
        if (!empty($errores)) {
            self::mostrarVista('login_view', ['errores' => $errores]);
            return;
        }

      
        $model = new LoginModel();
        $usuarioAutenticado = $model->autentificarUsuario($usuarioInput, $passwordInput);
        
        if ($usuarioAutenticado) {
           
           
            $_SESSION['usuario'] = $usuarioAutenticado;
            
            // hay que redirigir?
            header('Location: principal');
            exit;
        } else {
            // errores de credencial
            $errores['general'] = "Usuario o contraseña incorrectos";
            self::mostrarVista('login_view', ['errores' => $errores]);
        }
    }

    public static function cerrarSesion() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // vaciar sesión + cookie
        $_SESSION = [];
        if (ini_get('session.use_cookies')) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                $params['path'], $params['domain'],
                $params['secure'], $params['httponly']
            );
        }
        session_unset();
        session_destroy();

        // redirigir usando BASE_URL (ruta pública)
        header('Location: ' . BASE_URL . '/login');
        exit;
    }
}
?>