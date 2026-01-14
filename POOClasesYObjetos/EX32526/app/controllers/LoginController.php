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
       

        session_unset();
        session_destroy();
        header("Location: login", true, 302);
        exit();

       
    }
}
?>