<?php
namespace RubenMolinaExamen\App\controllers;

use RubenMolinaExamen\App\models\LoginModel;
use RubenMolinaExamen\Lib\SessionManager;

class LoginController extends Controller {
    
    
    public static function mostrarFormularioLogin() {
        
        
     
         
    if (isset($_SESSION['usuario'])) {
        $usuario = SessionManager::estaAutentificado($_SESSION['usuario']);
        if ($usuario) {
            header("Location: " . BASE_URL . "principal");
            exit();
        }
    }
 

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
       

        SessionManager::destruirSesion();
        header("Location: login", true, 302);
        exit();

       
    }
}
?>